<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function create(Request $request): Response
    {
        $menuItems = MenuItem::where('is_available', true)->orderBy('category')->orderBy('name')->get();

        return Inertia::render('Cashier/Orders/Create', [
            'menuItems' => $menuItems,
            'taxRate' => (float) config('app.order_tax_rate', 0),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'table_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
        ]);

        $taxRate = (float) ($validated['tax_rate'] ?? config('app.order_tax_rate', 0));
        $discount = (float) ($validated['discount'] ?? 0);

        $order = DB::transaction(function () use ($validated, $taxRate, $discount) {
            $order = new Order;
            $order->order_number = Order::generateOrderNumber();
            $order->user_id = auth()->id();
            $order->customer_name = $validated['customer_name'] ?? null;
            $order->table_number = $validated['table_number'] ?? null;
            $order->notes = $validated['notes'] ?? null;
            $order->tax_rate = $taxRate;
            $order->discount = $discount;
            $order->status = Order::STATUS_PENDING;

            $subtotal = 0;
            foreach ($validated['items'] as $row) {
                $item = MenuItem::findOrFail($row['menu_item_id']);
                $qty = (int) $row['quantity'];
                $unitPrice = (float) $item->price;
                $lineTotal = round($unitPrice * $qty, 2);
                $subtotal += $lineTotal;
            }

            $order->subtotal = round($subtotal, 2);
            $order->tax_amount = round($order->subtotal * ($taxRate / 100), 2);
            $order->total = round($order->subtotal + $order->tax_amount - $discount, 2);
            $order->save();

            foreach ($validated['items'] as $row) {
                $item = MenuItem::findOrFail($row['menu_item_id']);
                $qty = (int) $row['quantity'];
                $unitPrice = (float) $item->price;
                $lineTotal = round($unitPrice * $qty, 2);
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item->id,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal' => $lineTotal,
                ]);
            }

            return $order;
        });

        return redirect()->route('cashier.orders.show', $order)->with('success', 'Order created.');
    }

    public function show(Order $order): Response
    {
        $order->load(['orderItems.menuItem', 'user', 'payments']);

        return Inertia::render('Cashier/Orders/Show', [
            'order' => $order,
        ]);
    }

    public function index(Request $request): Response
    {
        $orders = Order::with(['user', 'orderItems.menuItem'])
            ->latest()
            ->paginate(20);

        return Inertia::render('Cashier/Orders/Index', ['orders' => $orders]);
    }

    public function confirm(Order $order): RedirectResponse
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return back()->with('error', 'Order cannot be confirmed.');
        }
        $order->update(['status' => Order::STATUS_CONFIRMED]);

        return back()->with('success', 'Order confirmed. Kitchen has been notified.');
    }
}
