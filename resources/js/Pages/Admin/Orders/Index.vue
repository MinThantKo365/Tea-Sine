<template>
  <AdminLayout>
    <h1 class="text-white mb-4">All Orders</h1>
    <div class="table-responsive">
      <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders.data" :key="order.id">
            <td>{{ order.order_number }}</td>
            <td>{{ order.customer_name || '—' }}</td>
            <td>${{ Number(order.total).toFixed(2) }}</td>
            <td><span :class="statusClass(order.status)">{{ order.status }}</span></td>
            <td>{{ new Date(order.created_at).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <nav v-if="orders.links?.length" class="mt-3">
      <div class="d-flex gap-1 flex-wrap">
        <Link v-for="(link, i) in orders.links" :key="i" :href="link.url || '#'" class="btn btn-sm" :class="link.active ? 'btn-primary' : 'btn-outline-secondary'" v-html="link.label" />
      </div>
    </nav>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../layout/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({ orders: Object })

function statusClass(s) {
  const map = { pending: 'text-warning', confirmed: 'text-info', preparing: 'text-primary', ready: 'text-success', completed: 'text-muted', cancelled: 'text-danger' }
  return map[s] || 'text-white'
}
</script>
