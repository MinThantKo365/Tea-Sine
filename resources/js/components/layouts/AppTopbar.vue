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
    <div class="topbar-actions">
      <ThemeToggle />
      <Link href="/account/password" class="topbar-password-link" title="Change password">
        <i class="fa-solid fa-key" aria-hidden="true"></i>
      </Link>
      <div class="topbar-user">
        <span class="user-name">{{ user?.name }}</span>
        <span class="badge bg-secondary ms-1">{{ user?.role?.display_name || 'User' }}</span>
      </div>
    </div>
  </header>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import ThemeToggle from '../ThemeToggle.vue'

defineProps({
  pageTitle: String,
  user: Object,
})

defineEmits(['toggle-sidebar'])
</script>

<style scoped>
.app-topbar {
  height: 64px;
  background: var(--ts-topbar-bg);
  border-bottom: 1px solid var(--ts-border);
  display: flex;
  align-items: center;
  padding: 0 1.5rem;
  gap: 1rem;
  position: sticky;
  top: 0;
  z-index: 1030;
  transition: background-color 0.25s ease, border-color 0.25s ease;
}
.topbar-toggle {
  background: none;
  border: 1px solid var(--ts-border);
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
  background: var(--ts-text);
  border-radius: 1px;
}
.topbar-title {
  flex: 1;
  font-size: 1.25rem;
  font-weight: 600;
  color: var(--ts-text);
}
.topbar-actions {
  display: flex;
  align-items: center;
  gap: 1rem;
}
.topbar-password-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: 1px solid var(--ts-border);
  background: var(--ts-surface-alt);
  color: var(--ts-text);
  text-decoration: none;
  transition: background 0.2s, border-color 0.2s, color 0.2s;
}
.topbar-password-link:hover {
  background: var(--ts-sidebar-hover);
  border-color: var(--ts-accent);
  color: var(--ts-accent);
}
.topbar-user .user-name {
  font-size: 0.9rem;
  color: var(--ts-text);
}
</style>
