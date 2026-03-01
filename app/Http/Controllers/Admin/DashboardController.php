<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Payslip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        $ordersToday = Order::whereDate('created_at', $today)->whereIn('status', ['completed', 'ready', 'preparing', 'confirmed']);
        $revenueToday = Payment::where('status', 'paid')->whereDate('created_at', $today)->sum('amount');
        $revenueMonth = Payment::where('status', 'paid')->where('created_at', '>=', $thisMonth)->sum('amount');
        $pendingOrders = Order::whereIn('status', ['pending', 'confirmed', 'preparing'])->count();
        $completedToday = Order::where('status', 'completed')->whereDate('updated_at', $today)->count();
        $salarySummary = Payslip::where('period_year', $today->year)
            ->where('period_month', $today->month)
            ->sum('net_salary');

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'orders_today' => $ordersToday->count(),
                'revenue_today' => round((float) $revenueToday, 2),
                'revenue_month' => round((float) $revenueMonth, 2),
                'pending_orders' => $pendingOrders,
                'completed_today' => $completedToday,
                'salary_summary' => round((float) $salarySummary, 2),
            ],
        ]);
    }
}
