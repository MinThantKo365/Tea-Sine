<template>
  <div class="welcome-page min-vh-100 d-flex flex-column">
    <Header />

    <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
      <div class="text-center welcome-content">
        <img src="/image/logo (2).png" alt="Tea Sine Logo" class="welcome-logo mb-4" />
        <h1 class="welcome-title mb-3">Hello World</h1>
        <p class="welcome-subtitle mb-0">
          Welcome to Tea Sine{{ auth ? `, ${auth.name}` : '' }}
        </p>
      </div>
    </main>

    <Footer />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Header from './layout/header.vue'
import Footer from './layout/footer.vue'

const page = usePage()
const auth = computed(() => page.props.auth?.user)
</script>

<style scoped>
.welcome-page {
  background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0a0a0a 100%);
  position: relative;
  overflow: hidden;
}

.welcome-page::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: 
    radial-gradient(circle at 30% 40%, rgba(100, 116, 139, 0.15) 0%, transparent 50%),
    radial-gradient(circle at 70% 60%, rgba(100, 116, 139, 0.15) 0%, transparent 50%);
  pointer-events: none;
}

.welcome-content {
  position: relative;
  z-index: 1;
}

.welcome-logo {
  height: 140px;
  width: auto;
  display: block;
  margin: 0 auto;
  filter: drop-shadow(0 8px 20px rgba(255, 255, 255, 0.15));
  transition: transform 0.3s ease, filter 0.3s ease;
}

.welcome-logo:hover {
  transform: translateY(-5px) scale(1.05);
  filter: drop-shadow(0 12px 30px rgba(255, 255, 255, 0.2));
}

.welcome-title {
  font-size: 4rem;
  font-weight: 700;
  color: #ffffff;
  letter-spacing: -2px;
  margin-bottom: 1rem;
}

.welcome-subtitle {
  font-size: 1.25rem;
  color: rgba(255, 255, 255, 0.8);
  font-weight: 300;
}

@media (max-width: 768px) {
  .welcome-title {
    font-size: 2.5rem;
  }
  
  .welcome-subtitle {
    font-size: 1rem;
  }
  
  .welcome-logo {
    height: 100px;
  }
}
</style>
