<template>
  <div class="theme-toggle dropdown">
    <button
      type="button"
      class="theme-toggle-btn"
      data-bs-toggle="dropdown"
      aria-expanded="false"
      aria-label="Appearance settings"
      title="Appearance"
    >
      <i v-if="resolvedTheme === 'light'" class="fa-solid fa-sun" aria-hidden="true"></i>
      <i v-else class="fa-solid fa-moon" aria-hidden="true"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end theme-menu">
      <li class="dropdown-header">Appearance</li>
      <li>
        <button
          type="button"
          class="dropdown-item theme-option"
          :class="{ active: theme === 'light' }"
          @click="setTheme('light')"
        >
          <i class="fa-solid fa-sun" aria-hidden="true"></i>
          <span>Light</span>
          <i v-if="theme === 'light'" class="fa-solid fa-check ms-auto" aria-hidden="true"></i>
        </button>
      </li>
      <li>
        <button
          type="button"
          class="dropdown-item theme-option"
          :class="{ active: theme === 'dark' }"
          @click="setTheme('dark')"
        >
          <i class="fa-solid fa-moon" aria-hidden="true"></i>
          <span>Dark</span>
          <i v-if="theme === 'dark'" class="fa-solid fa-check ms-auto" aria-hidden="true"></i>
        </button>
      </li>
      <li>
        <button
          type="button"
          class="dropdown-item theme-option"
          :class="{ active: theme === 'system' }"
          @click="setTheme('system')"
        >
          <i class="fa-solid fa-desktop" aria-hidden="true"></i>
          <span>System</span>
          <i v-if="theme === 'system'" class="fa-solid fa-check ms-auto" aria-hidden="true"></i>
        </button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { useTheme } from '../composables/useTheme'

const { theme, resolvedTheme, setTheme } = useTheme()
</script>

<style scoped>
.theme-toggle-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: 1px solid var(--ts-border);
  background: var(--ts-surface-alt);
  color: var(--ts-text);
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, color 0.2s;
  font-size: 1rem;
}
.theme-toggle-btn:hover {
  background: var(--ts-sidebar-hover);
  border-color: var(--ts-accent);
  color: var(--ts-accent);
}
.theme-menu {
  min-width: 180px;
  background: var(--ts-surface);
  border-color: var(--ts-border);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}
.theme-option {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  color: var(--ts-text);
}
.theme-option i:first-child {
  width: 1.1rem;
  text-align: center;
}
.theme-option:hover,
.theme-option:focus {
  background: var(--ts-sidebar-hover);
  color: var(--ts-text);
}
.theme-option.active {
  background: var(--ts-sidebar-active-bg);
  color: var(--ts-accent);
}
</style>
