<template>
  <StaffLayout>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-white mb-0">Payslip</h1>
      <Link href="/staff/payslips" class="btn btn-outline-light">Back</Link>
    </div>
    <div class="card bg-dark border-secondary">
      <div class="card-body">
        <h5 class="text-white">Tea Sine - Payslip</h5>
        <p class="text-muted small">Period: {{ payslip.period_month }}/{{ payslip.period_year }}</p>
        <p class="text-white">Employee: {{ payslip.staff?.user?.name }} ({{ payslip.staff?.employee_code }})</p>
        <hr class="border-secondary" />
        <div class="d-flex justify-content-between text-white mb-1"><span>Basic Salary</span><span>{{ formatCurrency(payslip.basic_salary) }}</span></div>
        <div class="d-flex justify-content-between text-white mb-1"><span>Overtime ({{ payslip.overtime_hours }} hrs)</span><span>{{ formatCurrency(payslip.overtime_pay) }}</span></div>
        <div class="d-flex justify-content-between text-white mb-1"><span>Bonus</span><span>{{ formatCurrency(payslip.bonus) }}</span></div>
        <div class="d-flex justify-content-between text-white mb-2"><span>Deduction</span><span>-{{ formatCurrency(payslip.deduction) }}</span></div>
        <hr class="border-secondary" />
        <div class="d-flex justify-content-between text-white fs-5"><strong>Net Salary</strong><strong>{{ formatCurrency(payslip.net_salary) }}</strong></div>
        <p class="text-muted small mt-2 mb-0">Status: {{ payslip.status }}</p>
      </div>
    </div>
  </StaffLayout>
</template>

<script setup>
import StaffLayout from '../../layout/StaffLayout.vue'
import { Link } from '@inertiajs/vue3'
import { formatCurrency } from '../../../utils/formatCurrency'

defineProps({ payslip: Object })
</script>
