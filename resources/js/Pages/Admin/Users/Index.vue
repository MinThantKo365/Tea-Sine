<template>
  <AdminLayout>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="text-white mb-0">User Accounts</h1>
      <Link href="/admin/users/create" class="btn btn-primary">
        <span>+ Create User</span>
      </Link>
    </div>

    <div v-if="$page.props.flash?.success" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ $page.props.flash.success }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="card bg-dark border-secondary">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-dark table-hover mb-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <!-- <th>Created At</th> -->
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                  <span class="badge bg-secondary">{{ user.role?.display_name || 'No Role' }}</span>
                </td>
                <!-- <td>{{ new Date(user.created_at).toLocaleDateString() }}</td> -->
              </tr>
              <tr v-if="users.length === 0">
                <td colspan="4" class="text-center text-muted py-4">No users found.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AdminLayout from '../../layout/AdminLayout.vue'

defineProps({
  users: {
    type: Array,
    required: true,
  },
})
</script>

<style scoped>
.table {
  margin-bottom: 0;
}

.table th {
  border-bottom: 2px solid rgba(255, 255, 255, 0.1);
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.85rem;
  letter-spacing: 0.5px;
  padding: 1rem;
}

.table td {
  padding: 1rem;
  vertical-align: middle;
}

.badge {
  padding: 0.35rem 0.65rem;
  font-size: 0.75rem;
  font-weight: 500;
}
</style>
