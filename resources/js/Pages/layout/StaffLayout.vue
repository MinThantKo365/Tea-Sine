<template>
  <div class="dashboard-layout">
    <AppSidebar
      title="Staff"
      brand-href="/staff/payslips"
      :menu-items="menuItems"
      :show-toggle="true"
      :is-open="sidebarOpen"
      @close="sidebarOpen = false"
    />
    <div class="layout-main">
      <AppTopbar
        :page-title="pageTitle"
        :user="user"
        @toggle-sidebar="sidebarOpen = !sidebarOpen"
      />
      <main class="layout-content">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppSidebar from '../../components/layouts/AppSidebar.vue'
import AppTopbar from '../../components/layouts/AppTopbar.vue'

const page = usePage()
const user = computed(() => page.props.auth?.user)
const pageTitle = computed(() => page.props.pageTitle || 'Staff')

const sidebarOpen = ref(false)

const menuItems = [
  { label: 'My Payslips', href: '/staff/payslips' },
  { label: 'Salary History', href: '/staff/payslips' },
]
</script>

<style scoped>
.dashboard-layout { display: flex; min-height: 100vh; background: #0a0a0a; }
.layout-main { flex: 1; margin-left: 260px; display: flex; flex-direction: column; min-width: 0; }
.layout-content { flex: 1; padding: 1.5rem; }
@media (max-width: 991.98px) {
  .layout-main { margin-left: 0; }
}
</style>
