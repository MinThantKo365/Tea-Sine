<template>
  <AdminLayout>
    <h1 class="text-white mb-4">Staff</h1>
    <div v-if="$page.props.flash?.success" class="alert alert-success">{{ $page.props.flash.success }}</div>
    <div class="table-responsive mb-4">
      <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th>Employee Code</th>
            <th>Name</th>
            <th>Basic Salary</th>
            <th>Overtime Rate/hr</th>
            <th>Joined</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="s in staff" :key="s.id">
            <td>{{ s.employee_code }}</td>
            <td>{{ s.user?.name }}</td>
            <td>${{ Number(s.basic_salary).toFixed(2) }}</td>
            <td>{{ s.overtime_rate_per_hour ? '$' + Number(s.overtime_rate_per_hour).toFixed(2) : '—' }}</td>
            <td>{{ s.joined_at ? new Date(s.joined_at).toLocaleDateString() : '—' }}</td>
            <td><button type="button" class="btn btn-sm btn-outline-light" @click="openEdit(s)">Edit</button></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card bg-dark border-secondary p-4">
      <h5 class="text-white mb-3">Add Staff Record</h5>
      <form @submit.prevent="addStaff">
        <div class="row g-2">
          <div class="col-md-4">
            <select v-model="addForm.user_id" class="form-select bg-secondary border-0 text-white" required>
              <option value="">Select user</option>
              <option v-for="u in usersWithoutStaff" :key="u.id" :value="u.id">{{ u.name }} ({{ u.role?.display_name }})</option>
            </select>
          </div>
          <div class="col-md-2">
            <input v-model="addForm.employee_code" type="text" class="form-control bg-secondary border-0 text-white" placeholder="Code" required />
          </div>
          <div class="col-md-2">
            <input v-model="addForm.basic_salary" type="number" step="0.01" min="0" class="form-control bg-secondary border-0 text-white" placeholder="Salary" required />
          </div>
          <div class="col-md-2">
            <input v-model="addForm.overtime_rate_per_hour" type="number" step="0.01" min="0" class="form-control bg-secondary border-0 text-white" placeholder="OT rate" />
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100" :disabled="addForm.processing">Add</button>
          </div>
        </div>
      </form>
    </div>
    <div v-if="editing" class="modal show d-block" tabindex="-1" style="background: rgba(0,0,0,0.7);">
      <div class="modal-dialog">
        <div class="modal-content bg-dark border-secondary">
          <div class="modal-header">
            <h5 class="modal-title text-white">Edit Staff</h5>
            <button type="button" class="btn-close btn-close-white" @click="editing = null"></button>
          </div>
          <form @submit.prevent="updateStaff">
            <div class="modal-body">
              <div class="mb-2">
                <label class="form-label text-white small">Employee Code</label>
                <input v-model="editForm.employee_code" type="text" class="form-control bg-secondary border-0 text-white" required />
              </div>
              <div class="mb-2">
                <label class="form-label text-white small">Basic Salary</label>
                <input v-model="editForm.basic_salary" type="number" step="0.01" min="0" class="form-control bg-secondary border-0 text-white" required />
              </div>
              <div class="mb-2">
                <label class="form-label text-white small">Overtime Rate/Hour</label>
                <input v-model="editForm.overtime_rate_per_hour" type="number" step="0.01" min="0" class="form-control bg-secondary border-0 text-white" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="editing = null">Cancel</button>
              <button type="submit" class="btn btn-primary" :disabled="editForm.processing">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '../../layout/AdminLayout.vue'

const props = defineProps({ staff: Array, usersWithoutStaff: Array })

const addForm = useForm({ user_id: '', employee_code: '', basic_salary: '', overtime_rate_per_hour: '', joined_at: '' })
function addStaff() {
  addForm.post('/admin/staff', { onSuccess: () => addForm.reset() })
}

const editing = ref(null)
const editForm = useForm({ employee_code: '', basic_salary: '', overtime_rate_per_hour: '' })
function openEdit(s) {
  editing.value = s
  editForm.employee_code = s.employee_code
  editForm.basic_salary = s.basic_salary
  editForm.overtime_rate_per_hour = s.overtime_rate_per_hour || ''
}
function updateStaff() {
  editForm.put(`/admin/staff/${editing.value.id}`, { onSuccess: () => { editing.value = null } })
}
</script>
