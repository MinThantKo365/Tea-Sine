<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payslip extends Model
{
    protected $fillable = [
        'staff_id', 'period_month', 'period_year',
        'basic_salary', 'overtime_hours', 'overtime_pay', 'bonus', 'deduction',
        'net_salary', 'status', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'basic_salary' => 'decimal:2',
            'overtime_hours' => 'decimal:2',
            'overtime_pay' => 'decimal:2',
            'bonus' => 'decimal:2',
            'deduction' => 'decimal:2',
            'net_salary' => 'decimal:2',
            'paid_at' => 'date',
        ];
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public static function calculateNetSalary(float $basic, float $overtimePay, float $bonus, float $deduction): float
    {
        return round($basic + $overtimePay + $bonus - $deduction, 2);
    }

    public function getPeriodLabelAttribute(): string
    {
        $months = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return ($months[$this->period_month] ?? '') . ' ' . $this->period_year;
    }
}
