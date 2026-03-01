<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class StaffController extends Controller
{
    public function index(): Response
    {
        $staff = Staff::with('user')->get();
        $usersWithoutStaff = User::whereHas('role')
            ->whereDoesntHave('staff')
            ->whereIn('role_id', Role::whereIn('name', ['staff', 'cashier', 'cook'])->pluck('id'))
            ->with('role')
            ->get();

        return Inertia::render('Admin/Staff/Index', [
            'staff' => $staff,
            'usersWithoutStaff' => $usersWithoutStaff,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'employee_code' => 'required|string|max:50|unique:staff,employee_code',
            'basic_salary' => 'required|numeric|min:0',
            'overtime_rate_per_hour' => 'nullable|numeric|min:0',
            'joined_at' => 'nullable|date',
        ]);

        Staff::create($validated);

        return redirect()->route('admin.staff.index')->with('success', 'Staff record created.');
    }

    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $validated = $request->validate([
            'employee_code' => 'required|string|max:50|unique:staff,employee_code,' . $staff->id,
            'basic_salary' => 'required|numeric|min:0',
            'overtime_rate_per_hour' => 'nullable|numeric|min:0',
            'joined_at' => 'nullable|date',
        ]);

        $staff->update($validated);

        return back()->with('success', 'Staff updated.');
    }
}
