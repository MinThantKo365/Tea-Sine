<template>
  <CashierLayout>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h1 class="text-white mb-0">Orders</h1>
        <p class="text-muted small mb-0">Auto-refreshes every 5 seconds</p>
      </div>
      <Link href="/cashier/orders/create" class="btn btn-primary">
        <i class="fa-solid fa-cart-plus me-1" aria-hidden="true"></i> New Order
      </Link>
    </div>
    <div class="card bg-dark border-secondary mb-4 p-3">
      <form @submit.prevent="filter" class="row g-2 align-items-end">
        <div class="col-auto">
          <label class="form-label text-white small mb-0">Date</label>
          <input v-model="filters.date" type="date" class="form-control form-control-sm bg-secondary border-0 text-white" />
        </div>
        <div class="col-auto">
          <label class="form-label text-white small mb-0">Order #</label>
          <input v-model="filters.order_number" type="text" class="form-control form-control-sm bg-secondary border-0 text-white" placeholder="e.g. ORD-20260702-0003" />
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-filter me-1" aria-hidden="true"></i> Filter
          </button>
        </div>
        <div class="col-auto">
          <button type="button" class="btn btn-sm btn-outline-light" @click="resetToday">
            Today
          </button>
        </div>
      </form>
    </div>
    <div class="table-responsive">
      <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="!orders.data?.length">
            <td colspan="6" class="text-muted text-center py-4">No orders match your filters.</td>
          </tr>
          <tr v-for="order in orders.data" :key="order.id">
            <td>{{ order.order_number }}</td>
            <td>{{ order.customer_name || '—' }}</td>
            <td>{{ formatCurrency(order.total) }}</td>
            <td><span :class="statusClass(order.status)">{{ order.status }}</span></td>
            <td>{{ new Date(order.created_at).toLocaleString() }}</td>
            <td><Link :href="`/cashier/orders/${order.id}`" class="btn btn-sm btn-outline-light">View</Link></td>
          </tr>
        </tbody>
      </table>
    </div>
    <nav v-if="orders.links?.length" class="mt-3">
      <div class="d-flex gap-1 flex-wrap">
        <Link v-for="(link, i) in orders.links" :key="i" :href="link.url || '#'" class="btn btn-sm" :class="link.active ? 'btn-primary' : 'btn-outline-secondary'" v-html="link.label" />
      </div>
    </nav>
  </CashierLayout>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import CashierLayout from '../../layout/CashierLayout.vue'
import { Link } from '@inertiajs/vue3'
import { formatCurrency } from '../../../utils/formatCurrency'

const props = defineProps({ orders: Object, filters: Object })

const today = new Date().toISOString().slice(0, 10)
const filters = ref({
  date: props.filters?.date || today,
  order_number: props.filters?.order_number || '',
})

let refreshInterval
onMounted(() => {
  refreshInterval = setInterval(
    () => router.reload({ only: ['orders'], preserveScroll: true }),
    5000
  )
})
onUnmounted(() => clearInterval(refreshInterval))

function filter() {
  router.get('/cashier/orders', filters.value, { preserveState: true })
}

function resetToday() {
  filters.value.date = today
  filters.value.order_number = ''
  filter()
}

function statusClass(s) {
  const map = { pending: 'text-warning', confirmed: 'text-info', preparing: 'text-primary', ready: 'text-success', completed: 'text-muted', cancelled: 'text-danger' }
  return map[s] || 'text-body'
}
</script>
