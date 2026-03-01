<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $start = $request->get('start', Carbon::now()->startOfMonth()->toDateString());
        $end = $request->get('end', Carbon::now()->toDateString());

        $revenue = Payment::where('status', 'paid')
            ->whereBetween('created_at', [$start, Carbon::parse($end)->endOfDay()])
            ->sum('amount');

        $ordersCount = Order::whereBetween('created_at', [$start, Carbon::parse($end)->endOfDay()])
            ->whereIn('status', ['completed', 'ready', 'preparing', 'confirmed'])
            ->count();

        $completedCount = Order::whereBetween('updated_at', [$start, Carbon::parse($end)->endOfDay()])
            ->where('status', 'completed')
            ->count();

        return Inertia::render('Admin/Reports/Index', [
            'start' => $start,
            'end' => $end,
            'revenue' => round((float) $revenue, 2),
            'ordersCount' => $ordersCount,
            'completedCount' => $completedCount,
        ]);
    }
}
