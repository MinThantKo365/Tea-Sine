<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Payment::with(['order', 'user'])->latest();

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(20)->withQueryString();

        $date = $request->get('date', now()->toDateString());
        $dailyTotal = Payment::where('status', 'paid')->whereDate('created_at', $date)->sum('amount');

        return Inertia::render('Cashier/Payments/Index', [
            'payments' => $payments,
            'filters' => $request->only('date', 'method', 'status'),
            'dailyTotal' => round((float) $dailyTotal, 2),
        ]);
    }

    public function create(Order $order): Response|RedirectResponse
    {
        if ($order->isPaid()) {
            return redirect()->route('cashier.orders.show', $order)->with('error', 'Order already paid.');
        }
        $order->load('orderItems.menuItem');

        return Inertia::render('Cashier/Payments/Create', [
            'order' => $order,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:cash,card,mobile',
            'reference' => 'nullable|string|max:255',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        if ($order->isPaid()) {
            return back()->withErrors(['order_id' => 'This order has already been paid.']);
        }

        $amount = (float) $validated['amount'];
        if ($amount < (float) $order->total) {
            return back()->withErrors(['amount' => 'Amount must be at least the order total.']);
        }

        DB::transaction(function () use ($validated, $order, $amount) {
            Payment::create([
                'order_id' => $order->id,
                'amount' => $amount,
                'method' => $validated['method'],
                'status' => Payment::STATUS_PAID,
                'reference' => $validated['reference'] ?? null,
                'user_id' => auth()->id(),
            ]);
            $order->update(['status' => Order::STATUS_COMPLETED]);
        });

        return redirect()->route('cashier.payments.receipt', $order)->with('success', 'Payment recorded.');
    }

    public function receipt(Order $order): Response
    {
        $order->load(['orderItems.menuItem', 'payments', 'user']);

        return Inertia::render('Cashier/Payments/Receipt', ['order' => $order]);
    }
}
