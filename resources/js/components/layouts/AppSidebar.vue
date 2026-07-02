<template>
  <aside class="app-sidebar" :class="{ 'open': isOpen }">
    <div class="sidebar-header">
      <Link :href="brandHref" class="sidebar-brand">
        <BrandLogo :height="'32px'" />
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
            :class="{ 'active': item.href === activeHref }"
            @click="$emit('close')"
          >
            <i v-if="item.icon" :class="[item.icon, 'nav-icon']" aria-hidden="true"></i>
            <span class="nav-label">{{ item.label }}</span>
          </Link>
        </li>
      </ul>
    </nav>
    <div class="sidebar-footer">
      <button type="button" class="nav-link logout-link" @click="logout">
        <i class="fa-solid fa-right-from-bracket nav-icon" aria-hidden="true"></i>
        <span class="nav-label">Logout</span>
      </button>
    </div>
  </aside>
</template>

<script setup>
import { computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import BrandLogo from '../BrandLogo.vue'

const props = defineProps({
  title: { type: String, default: 'Tea Sine' },
  brandHref: { type: String, default: '/dashboard' },
  menuItems: { type: Array, required: true },
  showToggle: Boolean,
  isOpen: Boolean,
})

defineEmits(['close'])

const page = usePage()

const activeHref = computed(() => {
  const path = page.url.split('?')[0]
  let best = null
  let bestLen = -1
  for (const item of props.menuItems) {
    const href = item.href
    const matches = href === path || (href !== '/' && path.startsWith(href + '/'))
    if (matches && href.length > bestLen) {
      best = href
      bestLen = href.length
    }
  }
  return best
})

function logout() {
  router.post('/logout')
}
</script>

<style scoped>
.app-sidebar {
  width: 260px;
  min-height: 100vh;
  background: var(--ts-sidebar-bg);
  border-right: 1px solid var(--ts-border);
  display: flex;
  flex-direction: column;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 1040;
  transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
}
.sidebar-header {
  padding: 1rem 1.25rem;
  border-bottom: 1px solid var(--ts-border);
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
  color: var(--ts-sidebar-text-hover);
  font-weight: 700;
  font-size: 1.1rem;
}
.sidebar-title { white-space: nowrap; }
.sidebar-close {
  background: none;
  border: none;
  color: var(--ts-sidebar-text);
  font-size: 1.5rem;
  line-height: 1;
  padding: 0.25rem;
  cursor: pointer;
}
.sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
.sidebar-nav .nav-link {
  color: var(--ts-sidebar-text);
  padding: 0.65rem 1.25rem;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  border-left: 3px solid transparent;
  transition: color 0.2s, background 0.2s;
}
.sidebar-nav .nav-link:hover {
  color: var(--ts-sidebar-text-hover);
  background: var(--ts-sidebar-hover);
}
.sidebar-nav .nav-link.active {
  color: var(--ts-accent);
  background: var(--ts-sidebar-active-bg);
  border-left-color: var(--ts-accent);
}
.nav-icon {
  opacity: 0.9;
  font-size: 1rem;
  width: 1.15rem;
  text-align: center;
  flex-shrink: 0;
}
.sidebar-footer {
  padding: 1rem;
  border-top: 1px solid var(--ts-border);
}
.logout-link {
  width: 100%;
  background: none;
  border: none;
  cursor: pointer;
  text-align: left;
  color: var(--ts-text-muted) !important;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}
.logout-link:hover {
  color: var(--ts-sidebar-text-hover) !important;
}
@media (max-width: 991.98px) {
  .app-sidebar {
    transform: translateX(-100%);
    box-shadow: none;
  }
  .app-sidebar.open {
    transform: translateX(0);
    box-shadow: 0 0 0 9999px var(--ts-overlay);
  }
}
</style>
