<template>
  <CashierLayout>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-white mb-0">Order {{ order.order_number }}</h1>
      <Link href="/cashier/orders" class="btn btn-outline-light">Back to Orders</Link>
    </div>
    <div v-if="$page.props.flash?.success" class="alert alert-success">{{ $page.props.flash.success }}</div>
    <div v-if="$page.props.flash?.error" class="alert alert-danger">{{ $page.props.flash.error }}</div>
    <div class="card bg-dark border-secondary mb-3">
      <div class="card-body">
        <p class="text-white mb-1"><strong>Customer:</strong> {{ order.customer_name || '—' }}</p>
        <p class="text-white mb-1"><strong>Table:</strong> {{ order.table_number || '—' }}</p>
        <p class="text-white mb-1"><strong>Status:</strong> <span :class="statusClass(order.status)">{{ order.status }}</span></p>
        <p class="text-white mb-0"><strong>Total:</strong> ${{ Number(order.total).toFixed(2) }}</p>
      </div>
    </div>
    <div class="card bg-dark border-secondary mb-3">
      <div class="card-header text-white">Items</div>
      <ul class="list-group list-group-flush">
        <li v-for="oi in order.order_items" :key="oi.id" class="list-group-item bg-dark border-secondary text-white d-flex justify-content-between">
          <span>{{ oi.menu_item?.name }} x{{ oi.quantity }}</span>
          <span>${{ Number(oi.subtotal).toFixed(2) }}</span>
        </li>
      </ul>
    </div>
    <div v-if="order.status === 'pending'" class="d-flex gap-2">
      <form @submit.prevent="confirmOrder" class="d-inline">
        <button type="submit" class="btn btn-success">Confirm Order (send to kitchen)</button>
      </form>
      <Link v-if="!order.payments?.length" :href="`/cashier/payments/order/${order.id}`" class="btn btn-primary">Process Payment</Link>
    </div>
    <Link v-else-if="order.status !== 'completed' && !order.payments?.length" :href="`/cashier/payments/order/${order.id}`" class="btn btn-primary">Process Payment</Link>
  </CashierLayout>
</template>

<script setup>
import CashierLayout from '../../layout/CashierLayout.vue'
import { Link, router, usePage } from '@inertiajs/vue3'

const props = defineProps({ order: Object })

function statusClass(s) {
  const map = { pending: 'text-warning', confirmed: 'text-info', preparing: 'text-primary', ready: 'text-success', completed: 'text-muted', cancelled: 'text-danger' }
  return map[s] || 'text-white'
}

function confirmOrder() {
  router.post(`/cashier/orders/${props.order.id}/confirm`)
}
</script>
