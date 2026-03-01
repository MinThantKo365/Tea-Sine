<template>
  <AdminLayout>
    <h1 class="text-white mb-4">Payments</h1>
    <div class="card bg-dark border-secondary mb-4 p-3">
      <form @submit.prevent="filter" class="row g-2 align-items-end">
        <div class="col-auto">
          <label class="form-label text-white small mb-0">Date</label>
          <input v-model="filters.date" type="date" class="form-control form-control-sm bg-secondary border-0 text-white" />
        </div>
        <div class="col-auto">
          <label class="form-label text-white small mb-0">Method</label>
          <select v-model="filters.method" class="form-select form-select-sm bg-secondary border-0 text-white">
            <option value="">All</option>
            <option value="cash">Cash</option>
            <option value="card">Card</option>
            <option value="mobile">Mobile</option>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </div>
      </form>
      <p class="text-white mb-0 mt-2">Daily total: <strong>${{ dailyTotal.toFixed(2) }}</strong></p>
    </div>
    <div class="table-responsive">
      <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Order #</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="p in payments.data" :key="p.id">
            <td>{{ p.id }}</td>
            <td>{{ p.order?.order_number }}</td>
            <td>${{ Number(p.amount).toFixed(2) }}</td>
            <td>{{ p.method }}</td>
            <td>{{ p.status }}</td>
            <td>{{ new Date(p.created_at).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <nav v-if="payments.links?.length" class="mt-3">
      <div class="d-flex gap-1 flex-wrap">
        <Link v-for="(link, i) in payments.links" :key="i" :href="link.url || '#'" class="btn btn-sm" :class="link.active ? 'btn-primary' : 'btn-outline-secondary'" v-html="link.label" />
      </div>
    </nav>
  </AdminLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '../../layout/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ payments: Object, filters: Object, dailyTotal: Number })

const filters = ref({ ...(props.filters || {}), date: props.filters?.date || '', method: props.filters?.method || '' })
watch(() => props.filters, (f) => { if (f) filters.value = { ...f } }, { deep: true })

function filter() {
  router.get('/admin/payments', filters.value, { preserveState: true })
}
</script>
