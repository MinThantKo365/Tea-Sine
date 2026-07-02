<template>
  <AdminLayout>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-white mb-0">User Accounts</h1>
      <Link href="/admin/users/create" class="btn btn-primary">
        <i class="fa-solid fa-user-plus me-1" aria-hidden="true"></i> Create User
      </Link>
    </div>

    <div v-if="$page.props.flash?.success" class="alert alert-success">{{ $page.props.flash.success }}</div>

    <div class="card bg-dark border-secondary">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-dark table-hover mb-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                  <span class="badge bg-secondary">{{ user.role?.display_name || 'No Role' }}</span>
                </td>
                <td>
                  <span class="badge" :class="user.status === 0 ? 'bg-success' : 'bg-danger'">
                    {{ user.status === 0 ? 'Active' : 'Suspended' }}
                  </span>
                </td>
                <td class="text-end">
                  <button type="button" class="btn btn-sm btn-outline-light me-1" @click="openEdit(user)">
                    <i class="fa-solid fa-pen-to-square me-1" aria-hidden="true"></i> Edit
                  </button>
                  <button type="button" class="btn btn-sm btn-outline-warning" @click="openPassword(user)">
                    <i class="fa-solid fa-key me-1" aria-hidden="true"></i> Password
                  </button>
                </td>
              </tr>
              <tr v-if="users.length === 0">
                <td colspan="5" class="text-center text-muted py-4">No users found.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Edit user modal -->
    <div v-if="editingUser" class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
      <div class="modal-dialog">
        <div class="modal-content bg-dark border-secondary">
          <form @submit.prevent="submitEdit">
            <div class="modal-header border-secondary">
              <h5 class="modal-title text-white">Edit User</h5>
              <button type="button" class="btn-close btn-close-white" @click="closeEdit"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label text-white">Name</label>
                <input v-model="editForm.name" type="text" class="form-control bg-secondary border-0 text-white" required />
                <div v-if="editForm.errors.name" class="text-danger small mt-1">{{ editForm.errors.name }}</div>
              </div>
              <div class="mb-3">
                <label class="form-label text-white">Email</label>
                <input v-model="editForm.email" type="email" class="form-control bg-secondary border-0 text-white" required />
                <div v-if="editForm.errors.email" class="text-danger small mt-1">{{ editForm.errors.email }}</div>
              </div>
              <div class="mb-3">
                <label class="form-label text-white">Role</label>
                <select v-model="editForm.role_id" class="form-select bg-secondary border-0 text-white" required>
                  <option value="">Select a role</option>
                  <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.display_name }}</option>
                </select>
                <div v-if="editForm.errors.role_id" class="text-danger small mt-1">{{ editForm.errors.role_id }}</div>
              </div>
              <div class="mb-3">
                <label class="form-label text-white">Status</label>
                <select v-model.number="editForm.status" class="form-select bg-secondary border-0 text-white" required>
                  <option :value="0">Active</option>
                  <option :value="1">Suspended</option>
                </select>
                <div v-if="editForm.errors.status" class="text-danger small mt-1">{{ editForm.errors.status }}</div>
              </div>
            </div>
            <div class="modal-footer border-secondary">
              <button type="button" class="btn btn-outline-secondary" @click="closeEdit">Cancel</button>
              <button type="submit" class="btn btn-primary" :disabled="editForm.processing">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Change password modal -->
    <div v-if="passwordUser" class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
      <div class="modal-dialog">
        <div class="modal-content bg-dark border-secondary">
          <form @submit.prevent="submitPassword">
            <div class="modal-header border-secondary">
              <h5 class="modal-title text-white">Change Password — {{ passwordUser.name }}</h5>
              <button type="button" class="btn-close btn-close-white" @click="closePassword"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label text-white">New Password</label>
                <input v-model="passwordForm.password" type="password" class="form-control bg-secondary border-0 text-white" required minlength="8" />
                <div v-if="passwordForm.errors.password" class="text-danger small mt-1">{{ passwordForm.errors.password }}</div>
              </div>
              <div class="mb-3">
                <label class="form-label text-white">Confirm Password</label>
                <input v-model="passwordForm.password_confirmation" type="password" class="form-control bg-secondary border-0 text-white" required minlength="8" />
              </div>
            </div>
            <div class="modal-footer border-secondary">
              <button type="button" class="btn btn-outline-secondary" @click="closePassword">Cancel</button>
              <button type="submit" class="btn btn-warning" :disabled="passwordForm.processing">Update Password</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '../../layout/AdminLayout.vue'

defineProps({
  users: { type: Array, required: true },
  roles: { type: Array, required: true },
})

const editingUser = ref(null)
const passwordUser = ref(null)

const editForm = useForm({
  name: '',
  email: '',
  role_id: '',
  status: 0,
})

const passwordForm = useForm({
  password: '',
  password_confirmation: '',
})

function openEdit(user) {
  editingUser.value = user
  editForm.name = user.name
  editForm.email = user.email
  editForm.role_id = user.role_id ?? ''
  editForm.status = user.status ?? 0
  editForm.clearErrors()
}

function closeEdit() {
  editingUser.value = null
  editForm.reset()
}

function submitEdit() {
  editForm.put(`/admin/users/${editingUser.value.id}`, {
    preserveScroll: true,
    onSuccess: () => closeEdit(),
  })
}

function openPassword(user) {
  passwordUser.value = user
  passwordForm.reset()
  passwordForm.clearErrors()
}

function closePassword() {
  passwordUser.value = null
  passwordForm.reset()
}

function submitPassword() {
  passwordForm.put(`/admin/users/${passwordUser.value.id}/password`, {
    preserveScroll: true,
    onSuccess: () => closePassword(),
  })
}
</script>
