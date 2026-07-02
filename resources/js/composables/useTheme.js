import { ref, computed } from 'vue'

const STORAGE_KEY = 'tea-sine-theme'

const theme = ref('system')
let initialized = false
let mediaQuery = null

function getSystemTheme() {
  if (typeof window === 'undefined') return 'light'
  return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
}

function resolveTheme(value) {
  return value === 'system' ? getSystemTheme() : value
}

function applyResolved(resolved) {
  document.documentElement.setAttribute('data-theme', resolved)
  document.documentElement.setAttribute('data-bs-theme', resolved)
}

export function useTheme() {
  const resolvedTheme = computed(() => resolveTheme(theme.value))

  function setTheme(value) {
    theme.value = value
    localStorage.setItem(STORAGE_KEY, value)
    applyResolved(resolveTheme(value))
  }

  function initTheme() {
    if (initialized || typeof window === 'undefined') return
    initialized = true

    const saved = localStorage.getItem(STORAGE_KEY) || 'system'
    theme.value = saved
    applyResolved(resolveTheme(saved))

    mediaQuery = window.matchMedia('(prefers-color-scheme: dark)')
    mediaQuery.addEventListener('change', () => {
      if (theme.value === 'system') {
        applyResolved(getSystemTheme())
      }
    })
  }

  return { theme, resolvedTheme, setTheme, initTheme }
}
