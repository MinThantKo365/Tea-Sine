<template>
  <aside class="app-sidebar" :class="{ 'open': isOpen }">
    <div class="sidebar-header">
      <Link :href="brandHref" class="sidebar-brand">
        <img v-if="logoUrl" :src="logoUrl" alt="Logo" class="sidebar-logo" />
        <span class="sidebar-title">{{ title }}</span>
      </Link>
      <button v-if="showToggle" type="button" class="sidebar-close d-lg-none" aria-label="Close menu" @click="$emit('close')">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <nav class="sidebar-nav">
      <ul class="nav flex-column">
        <li v-for="item in menuItems" :key="item.href" class="nav-item">
          <Link
            :href="item.href"
            class="nav-link"
            :class="{ 'active': isActive(item.href) }"
            @click="$emit('close')"
          >
            <span v-if="item.icon" class="nav-icon" v-html="item.icon"></span>
            <span class="nav-label">{{ item.label }}</span>
          </Link>
        </li>
      </ul>
    </nav>
    <div class="sidebar-footer">
      <button type="button" class="nav-link logout-link" @click="logout">
        <span class="nav-icon">&#x2190;</span>
        <span class="nav-label">Logout</span>
      </button>
    </div>
  </aside>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'

defineProps({
  title: { type: String, default: 'Tea Sine' },
  logoUrl: { type: String, default: '/image/logo (2).png' },
  brandHref: { type: String, default: '/dashboard' },
  menuItems: { type: Array, required: true },
  showToggle: Boolean,
  isOpen: Boolean,
})

defineEmits(['close'])

function isActive(href) {
  if (typeof window === 'undefined') return false
  const path = window.location.pathname
  if (href === path) return true
  if (href !== '/' && path.startsWith(href)) return true
  return false
}

function logout() {
  router.post('/logout')
}
</script>

<style scoped>
.app-sidebar {
  width: 260px;
  min-height: 100vh;
  background: #0f0f0f;
  border-right: 1px solid rgba(255,255,255,0.08);
  display: flex;
  flex-direction: column;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 1040;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.sidebar-header {
  padding: 1rem 1.25rem;
  border-bottom: 1px solid rgba(255,255,255,0.06);
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 64px;
}
.sidebar-brand {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  text-decoration: none;
  color: #fff;
  font-weight: 700;
  font-size: 1.1rem;
}
.sidebar-logo { height: 36px; width: auto; }
.sidebar-title { white-space: nowrap; }
.sidebar-close {
  background: none;
  border: none;
  color: rgba(255,255,255,0.7);
  font-size: 1.5rem;
  line-height: 1;
  padding: 0.25rem;
  cursor: pointer;
}
.sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
.sidebar-nav .nav-link {
  color: rgba(255,255,255,0.75);
  padding: 0.65rem 1.25rem;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  border-left: 3px solid transparent;
  transition: color 0.2s, background 0.2s;
}
.sidebar-nav .nav-link:hover {
  color: #fff;
  background: rgba(255,255,255,0.06);
}
.sidebar-nav .nav-link.active {
  color: #fff;
  background: rgba(255,255,255,0.08);
  border-left-color: #0d6efd;
}
.nav-icon { opacity: 0.9; font-size: 1rem; }
.sidebar-footer {
  padding: 1rem;
  border-top: 1px solid rgba(255,255,255,0.06);
}
.logout-link {
  width: 100%;
  background: none;
  border: none;
  cursor: pointer;
  text-align: left;
  color: rgba(255,255,255,0.6) !important;
}
.logout-link:hover { color: #fff !important; }
@media (max-width: 991.98px) {
  .app-sidebar {
    transform: translateX(-100%);
    box-shadow: none;
  }
  .app-sidebar.open {
    transform: translateX(0);
    box-shadow: 0 0 0 9999px rgba(0,0,0,0.5);
  }
}
</style>
