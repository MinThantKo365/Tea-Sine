<?php

namespace App\Http\Controllers\Cook;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(Request $request): Response
    {
        $orders = Order::with(['orderItems.menuItem', 'user'])
            ->whereIn('status', ['confirmed', 'preparing', 'ready'])
            ->orderByRaw("CASE status WHEN 'confirmed' THEN 1 WHEN 'preparing' THEN 2 WHEN 'ready' THEN 3 ELSE 0 END")
            ->orderBy('created_at')
            ->get();

        return Inertia::render('Cook/Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function completed(Request $request): Response
    {
        $orders = Order::with(['orderItems.menuItem', 'user'])
            ->where('status', 'completed')
            ->orderByDesc('updated_at')
            ->paginate(20);

        return Inertia::render('Cook/Orders/Completed', [
            'orders' => $orders,
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,preparing,ready',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated.');
    }

    public function confirm(Order $order): RedirectResponse
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return back()->with('error', 'Order cannot be confirmed.');
        }
        $order->update(['status' => Order::STATUS_CONFIRMED]);

        return back()->with('success', 'Order confirmed.');
    }
}
