<template>
  <component :is="layout">
    <h1 class="text-white mb-4">Change Password</h1>
    <div v-if="$page.props.flash?.success" class="alert alert-success">{{ $page.props.flash.success }}</div>
    <form @submit.prevent="submit" class="card bg-dark border-secondary p-4" style="max-width: 480px;">
      <div class="mb-3">
        <label class="form-label text-white">Current Password</label>
        <input v-model="form.current_password" type="password" class="form-control bg-secondary border-0 text-white" required />
        <div v-if="form.errors.current_password" class="text-danger small mt-1">{{ form.errors.current_password }}</div>
      </div>
      <div class="mb-3">
        <label class="form-label text-white">New Password</label>
        <input v-model="form.password" type="password" class="form-control bg-secondary border-0 text-white" required minlength="8" />
        <div v-if="form.errors.password" class="text-danger small mt-1">{{ form.errors.password }}</div>
      </div>
      <div class="mb-4">
        <label class="form-label text-white">Confirm New Password</label>
        <input v-model="form.password_confirmation" type="password" class="form-control bg-secondary border-0 text-white" required minlength="8" />
      </div>
      <button type="submit" class="btn btn-primary" :disabled="form.processing">
        <i class="fa-solid fa-key me-1" aria-hidden="true"></i>
        {{ form.processing ? 'Updating...' : 'Update Password' }}
      </button>
    </form>
  </component>
</template>

<script setup>
import { computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import AdminLayout from '../layout/AdminLayout.vue'
import CashierLayout from '../layout/CashierLayout.vue'
import CookLayout from '../layout/CookLayout.vue'
import StaffLayout from '../layout/StaffLayout.vue'

const page = usePage()

const layout = computed(() => {
  const role = page.props.auth?.user?.role?.name
  const layouts = {
    admin: AdminLayout,
    cashier: CashierLayout,
    cook: CookLayout,
    staff: StaffLayout,
  }
  return layouts[role] || AdminLayout
})

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

function submit() {
  form.put('/account/password', { preserveScroll: true })
}
</script>
