<template>
  <AdminLayout>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-white mb-0">Payslips</h1>
      <Link href="/admin/payslips/create" class="btn btn-primary">Generate Payslip</Link>
    </div>
    <div v-if="$page.props.flash?.success" class="alert alert-success">{{ $page.props.flash.success }}</div>
    <div class="card bg-dark border-secondary mb-3 p-3">
      <form @submit.prevent="applyFilter" class="row g-2 align-items-end">
        <div class="col-auto">
          <label class="form-label text-white small mb-0">Year</label>
          <input v-model="filters.year" type="number" min="2020" class="form-control form-control-sm bg-secondary border-0 text-white" placeholder="Year" />
        </div>
        <div class="col-auto">
          <label class="form-label text-white small mb-0">Month</label>
          <select v-model="filters.month" class="form-select form-select-sm bg-secondary border-0 text-white">
            <option value="">All</option>
            <option v-for="m in 12" :key="m" :value="m">{{ m }}</option>
          </select>
        </div>
        <div class="col-auto">
          <label class="form-label text-white small mb-0">Staff</label>
          <select v-model="filters.staff_id" class="form-select form-select-sm bg-secondary border-0 text-white">
            <option value="">All</option>
            <option v-for="s in staffList" :key="s.id" :value="s.id">{{ s.user?.name }} ({{ s.employee_code }})</option>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </div>
      </form>
    </div>
    <div class="table-responsive">
      <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th>Staff</th>
            <th>Period</th>
            <th>Basic</th>
            <th>Overtime</th>
            <th>Bonus</th>
            <th>Deduction</th>
            <th>Net</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="p in payslips.data" :key="p.id">
            <td>{{ p.staff?.user?.name }}</td>
            <td>{{ p.period_month }}/{{ p.period_year }}</td>
            <td>${{ Number(p.basic_salary).toFixed(2) }}</td>
            <td>${{ Number(p.overtime_pay).toFixed(2) }}</td>
            <td>${{ Number(p.bonus).toFixed(2) }}</td>
            <td>${{ Number(p.deduction).toFixed(2) }}</td>
            <td>${{ Number(p.net_salary).toFixed(2) }}</td>
            <td>{{ p.status }}</td>
            <td>
              <button v-if="p.status === 'pending'" type="button" class="btn btn-sm btn-success" @click="markPaid(p)">Mark Paid</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <nav v-if="payslips.links?.length" class="mt-3">
      <div class="d-flex gap-1 flex-wrap">
        <Link v-for="(link, i) in payslips.links" :key="i" :href="link.url || '#'" class="btn btn-sm" :class="link.active ? 'btn-primary' : 'btn-outline-secondary'" v-html="link.label" />
      </div>
    </nav>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '../../layout/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ payslips: Object, staffList: Array, filters: Object })
const filters = ref({ ...(props.filters || {}), year: props.filters?.year || '', month: props.filters?.month || '', staff_id: props.filters?.staff_id || '' })

function applyFilter() {
  router.get('/admin/payslips', filters.value, { preserveState: true })
}

function markPaid(p) {
  if (confirm('Mark this payslip as paid?')) {
    router.post(`/admin/payslips/${p.id}/paid`, {}, { preserveScroll: true })
  }
}
</script>
