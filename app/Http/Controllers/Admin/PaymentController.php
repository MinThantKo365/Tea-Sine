<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
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

        $payments = $query->paginate(20)->withQueryString();
        $dailyTotal = $request->filled('date')
            ? Payment::where('status', 'paid')->whereDate('created_at', $request->date)->sum('amount')
            : Payment::where('status', 'paid')->whereDate('created_at', now())->sum('amount');

        return Inertia::render('Admin/Payments/Index', [
            'payments' => $payments,
            'filters' => $request->only('date', 'method'),
            'dailyTotal' => round((float) $dailyTotal, 2),
        ]);
    }
}
