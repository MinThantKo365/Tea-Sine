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
      <div class="topbar-user">
        <span class="user-name">{{ user?.name }}</span>
        <span class="badge bg-secondary ms-1">{{ user?.role?.display_name || 'User' }}</span>
      </div>
    </div>
  </header>
</template>

<script setup>
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
.topbar-user .user-name {
  font-size: 0.9rem;
  color: var(--ts-text);
}
</style>
