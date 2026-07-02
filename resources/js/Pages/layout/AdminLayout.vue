<template>
  <div class="dashboard-layout">
    <AppSidebar
      title="Admin Panel"
      brand-href="/admin/dashboard"
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
const pageTitle = computed(() => page.props.pageTitle || 'Admin')

const sidebarOpen = ref(false)

const menuItems = [
  { label: 'Dashboard', href: '/admin/dashboard', icon: 'fa-solid fa-gauge' },
  { label: 'Orders', href: '/admin/orders', icon: 'fa-solid fa-receipt' },
  { label: 'Payments', href: '/admin/payments', icon: 'fa-solid fa-credit-card' },
  { label: 'Menu Management', href: '/admin/menu-items', icon: 'fa-solid fa-utensils' },
  { label: 'User Accounts', href: '/admin/users', icon: 'fa-solid fa-users' },
  // { label: 'Staff', href: '/admin/staff' },
  // { label: 'Payslips', href: '/admin/payslips' },
  // { label: 'Reports', href: '/admin/reports' },
]
</script>
