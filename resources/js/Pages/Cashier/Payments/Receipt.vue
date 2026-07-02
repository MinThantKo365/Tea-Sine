<template>
  <CashierLayout>
    <div class="receipt-toolbar d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-white mb-0">Receipt - {{ order.order_number }}</h1>
      <div>
        <button type="button" class="btn btn-outline-light me-2" @click="printReceipt">
          <i class="fa-solid fa-print me-1" aria-hidden="true"></i> Print
        </button>
        <Link href="/cashier/orders/create" class="btn btn-primary">
          <i class="fa-solid fa-cart-plus me-1" aria-hidden="true"></i> New Order
        </Link>
      </div>
    </div>
    <div v-if="$page.props.flash?.success" class="alert alert-success no-print">{{ $page.props.flash.success }}</div>

    <div id="receipt-print" class="printable receipt-paper card bg-dark border-secondary">
      <div class="receipt-body p-2">
        <h5 class="receipt-shop text-white">Tea Sine</h5>
        <p class="receipt-meta text-muted small mb-1">Order # {{ order.order_number }}</p>
        <p class="receipt-meta text-muted small mb-1">Date: {{ formattedDate }}</p>
        <p class="receipt-meta text-white mb-2">Customer: {{ order.customer_name || '—' }} | Table: {{ order.table_number || '—' }}</p>
        <hr class="receipt-divider border-secondary" />
        <ul class="list-unstyled receipt-items mb-0">
          <li v-for="oi in order.order_items" :key="oi.id" class="receipt-item text-white">
            <div class="receipt-item-name">{{ oi.menu_item?.name }} x{{ oi.quantity }}</div>
            <div class="receipt-item-price">{{ formatCurrency(oi.subtotal) }}</div>
          </li>
        </ul>
        <hr class="receipt-divider border-secondary" />
        <div class="receipt-row text-white"><span>Subtotal</span><span>{{ formatCurrency(order.subtotal) }}</span></div>
        <div class="receipt-row text-white"><span>Tax</span><span>{{ formatCurrency(order.tax_amount) }}</span></div>
        <div class="receipt-row text-white"><span>Discount</span><span>-{{ formatCurrency(order.discount) }}</span></div>
        <div class="receipt-row receipt-total text-white"><strong>Total</strong><strong>{{ formatCurrency(order.total) }}</strong></div>
        <hr class="receipt-divider border-secondary" />
        <p class="receipt-meta text-muted small mb-0">Payment: {{ order.payments?.[0]?.method }} - {{ formatCurrency(order.payments?.[0]?.amount || 0) }}</p>
        <p class="receipt-meta text-muted small mb-0">Thank you!</p>
      </div>
    </div>
  </CashierLayout>
</template>

<script setup>
import { computed } from 'vue'
import CashierLayout from '../../layout/CashierLayout.vue'
import { Link } from '@inertiajs/vue3'
import { formatCurrency } from '../../../utils/formatCurrency'

const props = defineProps({ order: Object })

const formattedDate = computed(() => new Date(props.order.created_at).toLocaleString())

function printReceipt() {
  window.print()
}
</script>

<style scoped>
.receipt-paper {
  max-width: 420px;
}
.receipt-item {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1rem;
  margin-bottom: 0.5rem;
}
.receipt-item-name {
  flex: 1;
}
.receipt-item-price {
  white-space: nowrap;
}
.receipt-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.25rem;
}
.receipt-total {
  font-size: 1.15rem;
  margin-top: 0.35rem;
}
</style>
