<template>
  <AdminLayout>
    <h1 class="text-white mb-4">Reports</h1>
    <form @submit.prevent="applyFilter" class="card bg-dark border-secondary mb-4 p-3">
      <div class="row g-2 align-items-end">
        <div class="col-auto">
          <label class="form-label text-white small mb-0">From</label>
          <input v-model="start" type="date" class="form-control form-control-sm bg-secondary border-0 text-white" />
        </div>
        <div class="col-auto">
          <label class="form-label text-white small mb-0">To</label>
          <input v-model="end" type="date" class="form-control form-control-sm bg-secondary border-0 text-white" />
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-sm btn-primary">Apply</button>
        </div>
      </div>
    </form>
    <div class="row g-3">
      <div class="col-12 col-md-4">
        <div class="card bg-dark border-secondary">
          <div class="card-body">
            <h6 class="text-muted text-uppercase small">Revenue</h6>
            <h3 class="text-white mb-0">${{ revenue.toFixed(2) }}</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card bg-dark border-secondary">
          <div class="card-body">
            <h6 class="text-muted text-uppercase small">Orders (period)</h6>
            <h3 class="text-white mb-0">{{ ordersCount }}</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card bg-dark border-secondary">
          <div class="card-body">
            <h6 class="text-muted text-uppercase small">Completed</h6>
            <h3 class="text-success mb-0">{{ completedCount }}</h3>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '../../layout/AdminLayout.vue'

const props = defineProps({ start: String, end: String, revenue: Number, ordersCount: Number, completedCount: Number })
const start = ref(props.start || '')
const end = ref(props.end || '')
watch(() => [props.start, props.end], ([s, e]) => { start.value = s || ''; end.value = e || '' }, { immediate: true })

function applyFilter() {
  router.get('/admin/reports', { start: start.value, end: end.value }, { preserveState: true })
}
</script>
