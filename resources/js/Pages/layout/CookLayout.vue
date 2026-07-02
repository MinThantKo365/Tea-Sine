<template>
  <div class="dashboard-layout cook-layout">
    <AppSidebar
      title="Kitchen"
      brand-href="/cook/orders"
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
const pageTitle = computed(() => page.props.pageTitle || 'Kitchen')

const sidebarOpen = ref(false)

const menuItems = [
  { label: 'Kitchen Orders', href: '/cook/orders', icon: 'fa-solid fa-fire-burner' },
  { label: 'Completed Orders', href: '/cook/orders/completed', icon: 'fa-solid fa-circle-check' },
]
</script>

<style scoped>
.cook-layout .layout-content { font-size: 1.05rem; }
</style>
