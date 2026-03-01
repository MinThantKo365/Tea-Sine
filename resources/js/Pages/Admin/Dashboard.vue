<template>
  <AdminLayout>
    <h1 class="text-white mb-4">Admin Dashboard</h1>
    <div class="row g-3">
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card bg-dark border-secondary">
          <div class="card-body">
            <h6 class="text-muted text-uppercase small">Orders Today</h6>
            <h3 class="text-white mb-0">{{ stats.orders_today }}</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card bg-dark border-secondary">
          <div class="card-body">
            <h6 class="text-muted text-uppercase small">Revenue Today</h6>
            <h3 class="text-white mb-0">${{ stats.revenue_today.toFixed(2) }}</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card bg-dark border-secondary">
          <div class="card-body">
            <h6 class="text-muted text-uppercase small">Revenue This Month</h6>
            <h3 class="text-white mb-0">${{ stats.revenue_month.toFixed(2) }}</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card bg-dark border-secondary">
          <div class="card-body">
            <h6 class="text-muted text-uppercase small">Pending Orders</h6>
            <h3 class="text-warning mb-0">{{ stats.pending_orders }}</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card bg-dark border-secondary">
          <div class="card-body">
            <h6 class="text-muted text-uppercase small">Completed Today</h6>
            <h3 class="text-success mb-0">{{ stats.completed_today }}</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card bg-dark border-secondary">
          <div class="card-body">
            <h6 class="text-muted text-uppercase small">Salary (This Month)</h6>
            <h3 class="text-info mb-0">${{ stats.salary_summary.toFixed(2) }}</h3>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '../layout/AdminLayout.vue'

defineProps({
  stats: {
    type: Object,
    required: true,
  },
})
</script>
