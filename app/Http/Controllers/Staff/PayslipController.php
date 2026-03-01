<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PayslipController extends Controller
{
    public function index(Request $request): Response
    {
        $staff = auth()->user()->staff;
        if (! $staff) {
            return Inertia::render('Staff/Payslips/Index', ['payslips' => [], 'staff' => null]);
        }

        $payslips = Payslip::where('staff_id', $staff->id)->with('staff.user')->latest()->paginate(12);

        return Inertia::render('Staff/Payslips/Index', [
            'payslips' => $payslips,
            'staff' => $staff->load('user'),
        ]);
    }

    public function show(Payslip $payslip): Response
    {
        $staff = auth()->user()->staff;
        if (! $staff || $payslip->staff_id !== $staff->id) {
            abort(403);
        }
        $payslip->load('staff.user');

        return Inertia::render('Staff/Payslips/Show', ['payslip' => $payslip]);
    }
}
