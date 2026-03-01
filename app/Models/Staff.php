<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = ['user_id', 'employee_code', 'basic_salary', 'overtime_rate_per_hour', 'joined_at'];

    protected function casts(): array
    {
        return [
            'basic_salary' => 'decimal:2',
            'overtime_rate_per_hour' => 'decimal:2',
            'joined_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payslips(): HasMany
    {
        return $this->hasMany(Payslip::class);
    }

    public function getOvertimeRateAttribute(): float
    {
        return (float) ($this->overtime_rate_per_hour ?? 0);
    }
}
