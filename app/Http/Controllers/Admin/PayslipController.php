<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PayslipController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Payslip::with('staff.user')->latest();

        if ($request->filled('year')) {
            $query->where('period_year', $request->year);
        }
        if ($request->filled('month')) {
            $query->where('period_month', $request->month);
        }
        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        $payslips = $query->paginate(20)->withQueryString();
        $staffList = Staff::with('user')->orderBy('employee_code')->get();

        return Inertia::render('Admin/Payslips/Index', [
            'payslips' => $payslips,
            'staffList' => $staffList,
            'filters' => $request->only('year', 'month', 'staff_id'),
        ]);
    }

    public function create(): Response
    {
        $staff = Staff::with('user')->orderBy('employee_code')->get();

        return Inertia::render('Admin/Payslips/Create', ['staff' => $staff]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'period_month' => 'required|integer|min:1|max:12',
            'period_year' => 'required|integer|min:2020|max:2100',
            'overtime_hours' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
        ]);

        $staff = Staff::findOrFail($validated['staff_id']);
        $basicSalary = (float) $staff->basic_salary;
        $overtimeHours = (float) ($validated['overtime_hours'] ?? 0);
        $overtimeRate = (float) ($staff->overtime_rate_per_hour ?? 0);
        $overtimePay = round($overtimeHours * $overtimeRate, 2);
        $bonus = (float) ($validated['bonus'] ?? 0);
        $deduction = (float) ($validated['deduction'] ?? 0);
        $netSalary = Payslip::calculateNetSalary($basicSalary, $overtimePay, $bonus, $deduction);

        $exists = Payslip::where('staff_id', $staff->id)
            ->where('period_month', $validated['period_month'])
            ->where('period_year', $validated['period_year'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['period' => 'Payslip already exists for this staff and period.']);
        }

        Payslip::create([
            'staff_id' => $staff->id,
            'period_month' => $validated['period_month'],
            'period_year' => $validated['period_year'],
            'basic_salary' => $basicSalary,
            'overtime_hours' => $overtimeHours,
            'overtime_pay' => $overtimePay,
            'bonus' => $bonus,
            'deduction' => $deduction,
            'net_salary' => $netSalary,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.payslips.index')->with('success', 'Payslip created.');
    }

    public function markPaid(Payslip $payslip): RedirectResponse
    {
        $payslip->update(['status' => 'paid', 'paid_at' => now()]);

        return back()->with('success', 'Payslip marked as paid.');
    }
}
