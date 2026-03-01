<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response|RedirectResponse
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isCashier()) {
            return redirect()->route('cashier.orders.create');
        }
        if ($user->isCook()) {
            return redirect()->route('cook.orders.index');
        }
        if ($user->isStaff()) {
            return redirect()->route('staff.payslips.index');
        }

        if (! $user->role_id) {
            return Inertia::render('Welcome');
        }

        return Inertia::render('Welcome');
    }
}
