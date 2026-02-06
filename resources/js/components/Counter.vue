<template>
  <div class="flex items-center gap-6">
    <button 
      @click="decrement"
      class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors"
    >
      -
    </button>
    <div class="text-5xl font-bold text-slate-900 dark:text-white min-w-32 text-center">
      {{ count }}
    </div>
    <button 
      @click="increment"
      class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors"
    >
      +
    </button>
  </div>
  <p class="text-sm text-slate-600 dark:text-slate-400 mt-6">
    Click the buttons to test Vue reactivity
  </p>
</template>

<script setup>
import { ref } from 'vue'

const count = ref(0)

const increment = () => count.value++
const decrement = () => count.value--
</script>
