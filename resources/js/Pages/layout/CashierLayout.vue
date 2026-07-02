<template>
  <div class="dashboard-layout">
    <AppSidebar
      title="Cashier"
      brand-href="/cashier/orders/create"
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
const pageTitle = computed(() => page.props.pageTitle || 'Cashier')

const sidebarOpen = ref(false)

const menuItems = [
  { label: 'Create Order', href: '/cashier/orders/create', icon: 'fa-solid fa-cart-plus' },
  { label: 'Order List', href: '/cashier/orders', icon: 'fa-solid fa-list' },
  { label: 'Payments', href: '/cashier/payments', icon: 'fa-solid fa-credit-card' },
]
</script>
