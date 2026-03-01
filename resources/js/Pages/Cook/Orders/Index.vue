<template>
  <CookLayout>
    <h1 class="text-white mb-4">Kitchen Orders</h1>
    <p class="text-muted small mb-2">Auto-refreshes every 10 seconds</p>
    <div v-if="$page.props.flash?.success" class="alert alert-success">{{ $page.props.flash.success }}</div>
    <div class="row g-3">
      <div v-for="order in orders" :key="order.id" class="col-12 col-md-6 col-lg-4">
        <div class="card h-100 border-2" :class="statusCardClass(order.status)">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-bold">{{ order.order_number }}</span>
            <span class="badge" :class="statusBadgeClass(order.status)">{{ order.status }}</span>
          </div>
          <div class="card-body bg-dark text-white">
            <p class="mb-1 small">Table: {{ order.table_number || '—' }} | {{ order.customer_name || 'Guest' }}</p>
            <ul class="list-unstyled mb-3">
              <li v-for="oi in order.order_items" :key="oi.id" class="d-flex justify-content-between">
                <span>{{ oi.menu_item?.name }} x{{ oi.quantity }}</span>
              </li>
            </ul>
            <p class="text-muted small mb-2">{{ new Date(order.created_at).toLocaleTimeString() }}</p>
            <div class="d-flex flex-wrap gap-1">
              <button v-if="order.status === 'confirmed'" type="button" class="btn btn-sm btn-warning" @click="updateStatus(order, 'preparing')">Preparing</button>
              <button v-if="order.status === 'preparing'" type="button" class="btn btn-sm btn-success" @click="updateStatus(order, 'ready')">Ready</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p v-if="!orders.length" class="text-muted">No active orders.</p>
  </CookLayout>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import CookLayout from '../../layout/CookLayout.vue'

defineProps({ orders: Array })

let refreshInterval
onMounted(() => {
  refreshInterval = setInterval(() => router.reload({ only: ['orders'] }), 10000)
})
onUnmounted(() => clearInterval(refreshInterval))

function statusCardClass(s) {
  const map = { confirmed: 'border-warning', preparing: 'border-primary', ready: 'border-success' }
  return map[s] || 'border-secondary'
}

function statusBadgeClass(s) {
  const map = { confirmed: 'bg-warning text-dark', preparing: 'bg-primary', ready: 'bg-success' }
  return map[s] || 'bg-secondary'
}

function updateStatus(order, status) {
  router.patch(`/cook/orders/${order.id}/status`, { status }, { preserveScroll: true })
}
</script>
