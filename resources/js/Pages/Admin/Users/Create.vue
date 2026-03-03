<template>
  <AdminLayout>
    <h1 class="text-white mb-4">Create User Account</h1>
    
    <div class="card bg-dark border-secondary p-4" style="max-width: 600px;">
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="form-label text-white">Name</label>
          <input 
            v-model="form.name" 
            type="text" 
            class="form-control bg-secondary border-0 text-white" 
            :class="{ 'is-invalid': form.errors.name }"
            required 
            placeholder="Enter full name"
          />
          <div v-if="form.errors.name" class="text-danger small mt-1">{{ form.errors.name }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-white">Email</label>
          <input 
            v-model="form.email" 
            type="email" 
            class="form-control bg-secondary border-0 text-white" 
            :class="{ 'is-invalid': form.errors.email }"
            required 
            placeholder="Enter email address"
          />
          <div v-if="form.errors.email" class="text-danger small mt-1">{{ form.errors.email }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-white">Role</label>
          <select 
            v-model="form.role_id" 
            class="form-select bg-secondary border-0 text-white" 
            :class="{ 'is-invalid': form.errors.role_id }"
            required
          >
            <option value="">Select a role</option>
            <option v-for="role in roles" :key="role.id" :value="role.id">
              {{ role.display_name }}
            </option>
          </select>
          <div v-if="form.errors.role_id" class="text-danger small mt-1">{{ form.errors.role_id }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-white">Password</label>
          <input 
            v-model="form.password" 
            type="password" 
            class="form-control bg-secondary border-0 text-white" 
            :class="{ 'is-invalid': form.errors.password }"
            required 
            placeholder="Enter password (min. 8 characters)"
            minlength="8"
          />
          <div v-if="form.errors.password" class="text-danger small mt-1">{{ form.errors.password }}</div>
        </div>

        <div class="mb-4">
          <label class="form-label text-white">Confirm Password</label>
          <input 
            v-model="form.password_confirmation" 
            type="password" 
            class="form-control bg-secondary border-0 text-white" 
            :class="{ 'is-invalid': form.errors.password_confirmation }"
            required 
            placeholder="Confirm password"
            minlength="8"
          />
          <div v-if="form.errors.password_confirmation" class="text-danger small mt-1">{{ form.errors.password_confirmation }}</div>
        </div>

        <div class="d-flex gap-2">
          <button 
            type="submit" 
            class="btn btn-primary" 
            :disabled="form.processing"
          >
            <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
            {{ form.processing ? 'Creating...' : 'Create User' }}
          </button>
          <Link href="/admin/users" class="btn btn-outline-secondary">
            Cancel
          </Link>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import AdminLayout from '../../layout/AdminLayout.vue'

const props = defineProps({
  roles: {
    type: Array,
    required: true,
  },
})

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role_id: '',
})

function submit() {
  form.post('/admin/users', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>

<style scoped>
.form-control:focus,
.form-select:focus {
  background-color: #495057;
  border-color: rgba(255, 255, 255, 0.25);
  color: #ffffff;
  box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1);
}

.is-invalid {
  border-color: #dc3545 !important;
}

.is-invalid:focus {
  border-color: #dc3545 !important;
  box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}
</style>
