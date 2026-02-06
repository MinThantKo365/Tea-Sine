<template>
  <div id="app" class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
    <nav class="sticky top-0 z-50 border-b border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center gap-2">
            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">TeaSine</div>
          </div>
          <div class="flex items-center gap-4">
            <button @click="toggleDarkMode" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">
              <span v-if="isDark">🌙</span>
              <span v-else>☀️</span>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <WelcomeCard />
        <StatsCard />
      </div>
      
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4 text-slate-900 dark:text-white">Counter Demo</h2>
        <CounterComponent />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import WelcomeCard from './WelcomeCard.vue'
import StatsCard from './StatsCard.vue'
import CounterComponent from './Counter.vue'

const isDark = ref(false)

onMounted(() => {
  isDark.value = document.documentElement.classList.contains('dark')
})

const toggleDarkMode = () => {
  isDark.value = !isDark.value
  if (isDark.value) {
    document.documentElement.classList.add('dark')
  } else {
    document.documentElement.classList.remove('dark')
  }
}
</script>
