<template>
  <AdminLayout>
    <h1 class="text-white mb-4">Edit Menu Item</h1>
    <form @submit.prevent="submit" class="card bg-dark border-secondary p-4" style="max-width: 500px;">
      <div class="mb-3">
        <label class="form-label text-white">Name</label>
        <input v-model="form.name" type="text" class="form-control bg-secondary border-0 text-white" required />
        <div v-if="form.errors.name" class="text-danger small">{{ form.errors.name }}</div>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Description</label>
        <textarea v-model="form.description" class="form-control bg-secondary border-0 text-white" rows="2"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Price</label>
        <input v-model="form.price" type="number" step="0.01" min="0" class="form-control bg-secondary border-0 text-white" required />
        <div v-if="form.errors.price" class="text-danger small">{{ form.errors.price }}</div>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">Category</label>
        <input v-model="form.category" type="text" class="form-control bg-secondary border-0 text-white" />
      </div>
      <div class="mb-3 form-check">
        <input v-model="form.is_available" type="checkbox" class="form-check-input" />
        <label class="form-check-label text-white">Available</label>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">Update</button>
        <Link href="/admin/menu-items" class="btn btn-outline-secondary">Cancel</Link>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '../../layout/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ menuItem: Object })

const form = useForm({
  name: props.menuItem.name,
  description: props.menuItem.description || '',
  price: props.menuItem.price,
  category: props.menuItem.category || '',
  is_available: props.menuItem.is_available ?? true,
})

function submit() {
  form.put(`/admin/menu-items/${props.menuItem.id}`)
}
</script>
