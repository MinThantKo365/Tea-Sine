<template>
  <header class="app-topbar">
    <button type="button" class="topbar-toggle d-lg-none" aria-label="Toggle menu" @click="$emit('toggle-sidebar')">
      <span class="hamburger"></span>
      <span class="hamburger"></span>
      <span class="hamburger"></span>
    </button>
    <div class="topbar-title">
      <slot name="title">
        <span v-if="pageTitle">{{ pageTitle }}</span>
      </slot>
    </div>
    <div class="topbar-user">
      <div class="dropdown">
        <button class="btn btn-link dropdown-toggle text-white text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="user-name">{{ user?.name }}</span>
          <span class="badge bg-secondary ms-1">{{ user?.role?.display_name || 'User' }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><span class="dropdown-item-text text-muted small">{{ user?.email }}</span></li>
          <li><hr class="dropdown-divider" /></li>
          <li>
            <button type="button" class="dropdown-item text-danger" @click="logout">Logout</button>
          </li>
        </ul>
      </div>
    </div>
  </header>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

defineProps({
  pageTitle: String,
  user: Object,
})

defineEmits(['toggle-sidebar'])

function logout() {
  router.post('/logout')
}
</script>

<style scoped>
.app-topbar {
  height: 64px;
  background: #0a0a0a;
  border-bottom: 1px solid rgba(255,255,255,0.08);
  display: flex;
  align-items: center;
  padding: 0 1.5rem;
  gap: 1rem;
  position: sticky;
  top: 0;
  z-index: 1030;
}
.topbar-toggle {
  background: none;
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 6px;
  padding: 0.5rem;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.topbar-toggle .hamburger {
  width: 20px;
  height: 2px;
  background: #fff;
  border-radius: 1px;
}
.topbar-title { flex: 1; font-size: 1.25rem; font-weight: 600; color: #fff; }
.topbar-user .user-name { font-size: 0.9rem; }
.topbar-user .dropdown-menu { background: #1a1a1a; border-color: rgba(255,255,255,0.1); }
.topbar-user .dropdown-item { color: rgba(255,255,255,0.9); }
.topbar-user .dropdown-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
</style>
