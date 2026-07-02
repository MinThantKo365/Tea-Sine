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
  { label: 'My Payslips', href: '/staff/payslips', icon: 'fa-solid fa-file-invoice-dollar' },
  { label: 'Salary History', href: '/staff/payslips', icon: 'fa-solid fa-clock-rotate-left' },
]
</script>
