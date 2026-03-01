<template>
  <CookLayout>
    <h1 class="text-white mb-4">Completed Orders</h1>
    <div class="table-responsive">
      <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Table</th>
            <th>Items</th>
            <th>Completed at</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders.data" :key="order.id">
            <td>{{ order.order_number }}</td>
            <td>{{ order.table_number || '—' }}</td>
            <td>
              <span v-for="(oi, i) in order.order_items" :key="oi.id">
                {{ i ? ', ' : '' }}{{ oi.menu_item?.name }} x{{ oi.quantity }}
              </span>
            </td>
            <td>{{ new Date(order.updated_at).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <nav v-if="orders.links?.length" class="mt-3">
      <div class="d-flex gap-1 flex-wrap">
        <Link v-for="(link, i) in orders.links" :key="i" :href="link.url || '#'" class="btn btn-sm" :class="link.active ? 'btn-primary' : 'btn-outline-secondary'" v-html="link.label" />
      </div>
    </nav>
  </CookLayout>
</template>

<script setup>
import CookLayout from '../../layout/CookLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({ orders: Object })
</script>
