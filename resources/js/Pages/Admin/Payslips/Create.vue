<template>
  <AdminLayout>
    <h1 class="text-white mb-4">Generate Payslip</h1>
    <form @submit.prevent="submit" class="card bg-dark border-secondary p-4" style="max-width: 500px;">
      <div class="mb-3">
        <label class="form-label text-white">Staff</label>
        <select v-model="form.staff_id" class="form-select bg-secondary border-0 text-white" required>
          <option value="">Select staff</option>
          <option v-for="s in staff" :key="s.id" :value="s.id">{{ s.user?.name }} ({{ s.employee_code }}) - ${{ Number(s.basic_salary).toFixed(2) }}</option>
        </select>
        <div v-if="form.errors.staff_id" class="text-danger small">{{ form.errors.staff_id }}</div>
      </div>
      <div class="row mb-3">
        <div class="col-6">
          <label class="form-label text-white">Month</label>
          <select v-model="form.period_month" class="form-select bg-secondary border-0 text-white" required>
            <option v-for="m in 12" :key="m" :value="m">{{ m }}</option>
          </select>
        </div>
        <div class="col-6">
          <label class="form-label text-white">Year</label>
          <input v-model="form.period_year" type="number" min="2020" class="form-control bg-secondary border-0 text-white" required />
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Overtime Hours</label>
        <input v-model="form.overtime_hours" type="number" step="0.5" min="0" class="form-control bg-secondary border-0 text-white" />
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Bonus</label>
        <input v-model="form.bonus" type="number" step="0.01" min="0" class="form-control bg-secondary border-0 text-white" />
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Deduction</label>
        <input v-model="form.deduction" type="number" step="0.01" min="0" class="form-control bg-secondary border-0 text-white" />
      </div>
      <div v-if="form.errors.period" class="text-danger small mb-2">{{ form.errors.period }}</div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">Create Payslip</button>
        <Link href="/admin/payslips" class="btn btn-outline-secondary">Cancel</Link>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '../../layout/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ staff: Array })
const now = new Date()

const form = useForm({
  staff_id: '',
  period_month: now.getMonth() + 1,
  period_year: now.getFullYear(),
  overtime_hours: 0,
  bonus: 0,
  deduction: 0,
})

function submit() {
  form.post('/admin/payslips')
}
</script>
