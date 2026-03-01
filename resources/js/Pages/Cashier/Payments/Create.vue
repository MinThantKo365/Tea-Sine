<template>
  <CashierLayout>
    <h1 class="text-white mb-4">Process Payment</h1>
    <div class="card bg-dark border-secondary mb-4">
      <div class="card-body">
        <p class="text-white mb-1">Order: <strong>{{ order.order_number }}</strong></p>
        <p class="text-white mb-0">Amount due: <strong>${{ Number(order.total).toFixed(2) }}</strong></p>
      </div>
    </div>
    <form @submit.prevent="submit" class="card bg-dark border-secondary p-4" style="max-width: 400px;">
      <div class="mb-3">
        <label class="form-label text-white">Amount</label>
        <input v-model="form.amount" type="number" step="0.01" min="0" class="form-control bg-secondary border-0 text-white" required />
        <div v-if="form.errors.amount" class="text-danger small">{{ form.errors.amount }}</div>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Method</label>
        <select v-model="form.method" class="form-select bg-secondary border-0 text-white" required>
          <option value="cash">Cash</option>
          <option value="card">Card</option>
          <option value="mobile">Mobile</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Reference (optional)</label>
        <input v-model="form.reference" type="text" class="form-control bg-secondary border-0 text-white" />
      </div>
      <div v-if="form.errors.order_id" class="text-danger small mb-2">{{ form.errors.order_id }}</div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">Record Payment</button>
        <Link :href="`/cashier/orders/${order.id}`" class="btn btn-outline-secondary">Cancel</Link>
      </div>
    </form>
  </CashierLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import CashierLayout from '../../layout/CashierLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ order: Object })

const form = useForm({
  order_id: props.order.id,
  amount: Number(props.order.total),
  method: 'cash',
  reference: '',
})

function submit() {
  form.post('/cashier/payments')
}
</script>
