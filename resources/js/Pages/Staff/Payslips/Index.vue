<template>
  <StaffLayout>
    <h1 class="text-white mb-4">My Payslips</h1>
    <div v-if="!staff" class="alert alert-info">No staff record linked to your account. Contact admin.</div>
    <div v-else>
      <div class="table-responsive">
        <table class="table table-dark table-striped">
          <thead>
            <tr>
              <th>Period</th>
              <th>Net Salary</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="p in payslips.data" :key="p.id">
              <td>{{ p.period_month }}/{{ p.period_year }}</td>
              <td>${{ Number(p.net_salary).toFixed(2) }}</td>
              <td>{{ p.status }}</td>
              <td><Link :href="`/staff/payslips/${p.id}`" class="btn btn-sm btn-outline-light">View</Link></td>
            </tr>
          </tbody>
        </table>
      </div>
      <nav v-if="payslips.links?.length" class="mt-3">
        <div class="d-flex gap-1 flex-wrap">
          <Link v-for="(link, i) in payslips.links" :key="i" :href="link.url || '#'" class="btn btn-sm" :class="link.active ? 'btn-primary' : 'btn-outline-secondary'" v-html="link.label" />
        </div>
      </nav>
    </div>
  </StaffLayout>
</template>

<script setup>
import StaffLayout from '../../layout/StaffLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({ payslips: Object, staff: Object })
</script>
