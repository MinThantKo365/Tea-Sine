<template>
  <CashierLayout>
    <h1 class="text-white mb-4">New Order</h1>
    <div v-if="form.errors.items" class="alert alert-danger">{{ form.errors.items }}</div>
    <div class="row">
      <div class="col-lg-8 mb-4">
        <div class="card bg-dark border-secondary">
          <div class="card-header text-white">Menu</div>
          <div class="card-body">
            <div class="row g-2">
              <div v-for="item in menuItems" :key="item.id" class="col-6 col-md-4">
                <button
                  type="button"
                  class="btn w-100 d-flex flex-column align-items-center p-3"
                  :class="item.is_available ? 'btn-outline-light' : 'btn-secondary disabled'"
                  :disabled="!item.is_available"
                  @click="addItem(item)"
                >
                  <span class="fw-bold text-truncate w-100">{{ item.name }}</span>
                  <small class="text-white-50">${{ Number(item.price).toFixed(2) }}</small>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card bg-dark border-secondary sticky-top">
          <div class="card-header text-white d-flex justify-content-between align-items-center">
            <span>Order</span>
            <span v-if="cart.length" class="badge bg-primary">{{ cart.length }} items</span>
          </div>
          <div class="card-body">
            <div v-if="!cart.length" class="text-muted">Add items from the menu.</div>
            <ul v-else class="list-group list-group-flush bg-transparent">
              <li v-for="(line, i) in cart" :key="i" class="list-group-item bg-transparent border-secondary d-flex justify-content-between align-items-center text-white">
                <span>{{ line.name }} x{{ line.quantity }}</span>
                <div>
                  <span class="me-2">${{ (line.unit_price * line.quantity).toFixed(2) }}</span>
                  <button type="button" class="btn btn-sm btn-outline-danger py-0" @click="removeAt(i)">×</button>
                </div>
              </li>
            </ul>
            <div class="mt-3">
              <div class="mb-2">
                <label class="form-label text-white small mb-0">Customer name</label>
                <input v-model="form.customer_name" type="text" class="form-control form-control-sm bg-secondary border-0 text-white" placeholder="Optional" />
              </div>
              <div class="mb-2">
                <label class="form-label text-white small mb-0">Table</label>
                <input v-model="form.table_number" type="text" class="form-control form-control-sm bg-secondary border-0 text-white" placeholder="Optional" />
              </div>
              <div class="mb-2">
                <label class="form-label text-white small mb-0">Tax %</label>
                <input v-model.number="form.tax_rate" type="number" step="0.1" min="0" class="form-control form-control-sm bg-secondary border-0 text-white" />
              </div>
              <div class="mb-2">
                <label class="form-label text-white small mb-0">Discount $</label>
                <input v-model.number="form.discount" type="number" step="0.01" min="0" class="form-control form-control-sm bg-secondary border-0 text-white" />
              </div>
            </div>
            <hr class="border-secondary" />
            <div class="d-flex justify-content-between text-white mb-1"><span>Subtotal</span><span>${{ subtotal.toFixed(2) }}</span></div>
            <div class="d-flex justify-content-between text-white mb-1"><span>Tax</span><span>${{ taxAmount.toFixed(2) }}</span></div>
            <div class="d-flex justify-content-between text-white mb-2"><span>Discount</span><span>-${{ form.discount || 0 }}</span></div>
            <div class="d-flex justify-content-between text-white fs-5"><strong>Total</strong><strong>${{ total.toFixed(2) }}</strong></div>
            <button type="button" class="btn btn-primary w-100 mt-3" :disabled="!cart.length || form.processing" @click="submit">Confirm Order</button>
          </div>
        </div>
      </div>
    </div>
  </CashierLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import CashierLayout from '../../layout/CashierLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({ menuItems: Array, taxRate: Number })

const cart = ref([])
function addItem(item) {
  const existing = cart.value.find((x) => x.menu_item_id === item.id)
  if (existing) existing.quantity++
  else cart.value.push({ menu_item_id: item.id, name: item.name, unit_price: Number(item.price), quantity: 1 })
}
function removeAt(i) {
  cart.value.splice(i, 1)
}

const form = useForm({
  customer_name: '',
  table_number: '',
  notes: '',
  tax_rate: props.taxRate ?? 0,
  discount: 0,
  items: [],
})

const subtotal = computed(() => cart.value.reduce((sum, l) => sum + l.unit_price * l.quantity, 0))
const taxAmount = computed(() => subtotal.value * ((form.tax_rate || 0) / 100))
const total = computed(() => Math.max(0, subtotal.value + taxAmount.value - (form.discount || 0)))

function submit() {
  form.items = cart.value.map((l) => ({ menu_item_id: l.menu_item_id, quantity: l.quantity }))
  form.post('/cashier/orders')
}
</script>
