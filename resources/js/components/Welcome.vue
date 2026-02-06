<template>
  <div class="welcome-page min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <!-- Header Section -->
    <header class="welcome-header bg-white dark:bg-slate-800 shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
          <h1 class="text-5xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 mb-4">
            Welcome to Tea Sine
          </h1>
          <p class="text-xl text-slate-600 dark:text-slate-300 mt-4">
            Your application is ready to code
          </p>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Features Grid -->
      <section class="mb-16">
        <h2 class="text-3xl font-bold text-center text-slate-800 dark:text-white mb-12">
          Getting Started
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            v-for="feature in features"
            :key="feature.id"
            @click="handleFeatureClick(feature.id)"
            class="feature-card bg-white dark:bg-slate-800 rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2 border border-slate-200 dark:border-slate-700"
          >
            <div class="text-4xl mb-4">{{ feature.icon }}</div>
            <h3 class="text-xl font-semibold text-slate-800 dark:text-white mb-2">
              {{ feature.title }}
            </h3>
            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
              {{ feature.description }}
            </p>
          </div>
        </div>
      </section>

      <!-- Quick Actions -->
      <section class="mb-16">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 border border-slate-200 dark:border-slate-700">
          <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">
            Quick Actions
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <button
              v-for="action in quickActions"
              :key="action.id"
              @click="handleAction(action.id)"
              class="action-button flex items-center gap-3 p-4 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105"
            >
              <span class="text-xl">{{ action.icon }}</span>
              <span>{{ action.label }}</span>
            </button>
          </div>
        </div>
      </section>

      <!-- Status Section -->
      <section class="mb-16">
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-8 border border-green-200 dark:border-green-800">
          <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">
            Project Status
          </h2>
          <ul class="space-y-3">
            <li
              v-for="status in projectStatus"
              :key="status.id"
              class="flex items-center gap-3 text-slate-700 dark:text-slate-200"
            >
              <span class="text-green-500 text-xl">{{ status.completed ? '✅' : '⏳' }}</span>
              <span :class="{ 'line-through opacity-50': status.completed }">
                {{ status.label }}
              </span>
            </li>
          </ul>
        </div>
      </section>

      <!-- Info Card -->
      <section>
        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-r-lg p-6 shadow-md">
          <div class="flex items-start gap-4">
            <div class="text-3xl">💡</div>
            <div>
              <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-200 mb-2">
                Ready to Code
              </h3>
              <p class="text-blue-800 dark:text-blue-300 leading-relaxed">
                This is a Laravel + Vue.js application with Inertia.js. You can start building your features by modifying this component or creating new ones in the components directory.
              </p>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-800 dark:bg-slate-900 text-white py-8 mt-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-slate-300">
          &copy; {{ currentYear }} Tea Sine. Built with Laravel & Vue.js
        </p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

props({
  name: String
})

const isLoaded = ref(false)
const features = ref([
  {
    id: 1,
    icon: '🚀',
    title: 'Quick Start',
    description: 'Begin building your application with pre-configured tools and dependencies.'
  },
  {
    id: 2,
    icon: '⚙️',
    title: 'Configuration',
    description: 'Customize settings in the config folder to match your requirements.'
  },
  {
    id: 3,
    icon: '📦',
    title: 'Components',
    description: 'Build reusable Vue components in the components directory.'
  },
  {
    id: 4,
    icon: '🎨',
    title: 'Styling',
    description: 'Style your application with Tailwind CSS for rapid development.'
  }
])

// Quick actions data
const quickActions = ref([
  {
    id: 'explore',
    icon: '📁',
    label: 'Explore Project Structure'
  },
  {
    id: 'api',
    icon: '🔌',
    label: 'Check API Routes'
  },
  {
    id: 'database',
    icon: '🗄️',
    label: 'Review Migrations'
  },
  {
    id: 'build',
    icon: '🛠️',
    label: 'Start Building Features'
  }
])

// Project status
const projectStatus = ref([
  {
    id: 1,
    label: 'Project setup complete',
    completed: true
  },
  {
    id: 2,
    label: 'Vue.js components configured',
    completed: true
  },
  {
    id: 3,
    label: 'Tailwind CSS integrated',
    completed: true
  },
  {
    id: 4,
    label: 'Ready for development',
    completed: true
  }
])

// Computed properties
const currentYear = computed(() => new Date().getFullYear())

// Lifecycle hooks
onMounted(() => {
  isLoaded.value = true
  console.log('Welcome component mounted and ready!')
  
  // You can add initialization logic here
  // Example: fetch initial data, setup event listeners, etc.
})

// Methods
const handleFeatureClick = (featureId) => {
  console.log(`Feature clicked: ${featureId}`)
  // Add your feature click handler logic here
  // Example: navigate to a route, show a modal, etc.
}

const handleAction = (actionId) => {
  console.log(`Action triggered: ${actionId}`)
  // Add your action handler logic here
  // Example: 
  // - navigate to routes
  // - open modals
  // - trigger API calls
  // - etc.
}

// Expose methods if needed for parent components
defineExpose({
  handleFeatureClick,
  handleAction
})
</script>

<style scoped>
/* Custom styles if needed */
.welcome-page {
  animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.feature-card {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.feature-card:hover {
  border-color: rgb(99, 102, 241);
}

.action-button:active {
  transform: scale(0.98);
}
</style>