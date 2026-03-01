<template>
  <CashierLayout>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-white mb-0">Receipt - {{ order.order_number }}</h1>
      <div>
        <button type="button" class="btn btn-outline-light me-2" @click="window.print()">Print</button>
        <Link href="/cashier/orders/create" class="btn btn-primary">New Order</Link>
      </div>
    </div>
    <div v-if="$page.props.flash?.success" class="alert alert-success">{{ $page.props.flash.success }}</div>
    <div class="card bg-dark border-secondary printable">
      <div class="card-body">
        <h5 class="text-white">Tea Sine</h5>
        <p class="text-muted small mb-1">Order # {{ order.order_number }}</p>
        <p class="text-muted small mb-1">Date: {{ new Date(order.created_at).toLocaleString() }}</p>
        <p class="text-white mb-2">Customer: {{ order.customer_name || '—' }} | Table: {{ order.table_number || '—' }}</p>
        <hr class="border-secondary" />
        <ul class="list-unstyled">
          <li v-for="oi in order.order_items" :key="oi.id" class="d-flex justify-content-between text-white mb-1">
            <span>{{ oi.menu_item?.name }} x{{ oi.quantity }}</span>
            <span>${{ Number(oi.subtotal).toFixed(2) }}</span>
          </li>
        </ul>
        <hr class="border-secondary" />
        <div class="d-flex justify-content-between text-white"><span>Subtotal</span><span>${{ Number(order.subtotal).toFixed(2) }}</span></div>
        <div class="d-flex justify-content-between text-white"><span>Tax</span><span>${{ Number(order.tax_amount).toFixed(2) }}</span></div>
        <div class="d-flex justify-content-between text-white"><span>Discount</span><span>-${{ Number(order.discount).toFixed(2) }}</span></div>
        <div class="d-flex justify-content-between text-white fs-5 mt-2"><strong>Total</strong><strong>${{ Number(order.total).toFixed(2) }}</strong></div>
        <hr class="border-secondary" />
        <p class="text-muted small mb-0">Payment: {{ order.payments?.[0]?.method }} - ${{ order.payments?.[0]?.amount ? Number(order.payments[0].amount).toFixed(2) : '0.00' }}</p>
        <p class="text-muted small">Thank you!</p>
      </div>
    </div>
  </CashierLayout>
</template>

<script setup>
import CashierLayout from '../../layout/CashierLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({ order: Object })
</script>

<style scoped>
@media print {
  .app-sidebar, .app-topbar, .btn, a[href], .layout-content > .d-flex { display: none !important; }
  .printable { border: 1px solid #333 !important; }
}
</style>
