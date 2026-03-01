<template>
  <AdminLayout>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-white mb-0">Menu Items</h1>
      <Link href="/admin/menu-items/create" class="btn btn-primary">Add Item</Link>
    </div>
    <div v-if="$page.props.flash?.success" class="alert alert-success">{{ $page.props.flash.success }}</div>
    <div class="table-responsive">
      <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Available</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in menuItems" :key="item.id">
            <td>{{ item.name }}</td>
            <td>{{ item.category || '—' }}</td>
            <td>${{ Number(item.price).toFixed(2) }}</td>
            <td><span :class="item.is_available ? 'text-success' : 'text-danger'">{{ item.is_available ? 'Yes' : 'No' }}</span></td>
            <td>
              <Link :href="`/admin/menu-items/${item.id}/edit`" class="btn btn-sm btn-outline-light me-1">Edit</Link>
              <button type="button" class="btn btn-sm btn-outline-danger" @click="confirmDelete(item)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import AdminLayout from '../../layout/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  menuItems: Array,
})

function confirmDelete(item) {
  if (confirm(`Delete "${item.name}"?`)) {
    router.delete(`/admin/menu-items/${item.id}`)
  }
}
</script>
