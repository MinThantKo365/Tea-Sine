<template>
  <footer class="footer-black border-top mt-auto py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
          <img src="/image/logo (2).png" alt="Tea Sine Logo" class="footer-logo mb-3" />
          <p class="small text-white-50 mb-0">Your trusted partner for quality solutions.</p>
        </div>

        <div class="col-md-4 mb-4 mb-md-0">
          <h6 class="small fw-semibold mb-3 text-white">Quick Links</h6>
          <ul class="list-unstyled small">
            <li class="mb-2"><a href="/" class="footer-link text-white-50 text-decoration-none">Home</a></li>
            <li class="mb-2"><a href="#" class="footer-link text-white-50 text-decoration-none">About</a></li>
            <li class="mb-2"><a href="#" class="footer-link text-white-50 text-decoration-none">Contact</a></li>
          </ul>
        </div>

        <div class="col-md-4">
          <h6 class="small fw-semibold mb-3 text-white">Contact</h6>
          <ul class="list-unstyled small text-white-50 mb-0">
            <li class="mb-2">info@teasine.com</li>
            <li>+1 (555) 123-4567</li>
          </ul>
        </div>
      </div>

      <div class="border-top border-white-10 mt-4 pt-4 text-center">
        <p class="small text-white-50 mb-0">&copy; {{ currentYear }} Tea Sine. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue'

const currentYear = computed(() => new Date().getFullYear())
</script>

<style scoped>
.footer-black {
  background: #000000 !important;
  border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
}

.footer-logo {
  height: 30px;
  width: auto;
  filter: drop-shadow(0 2px 4px rgba(255, 255, 255, 0.1));
}

.border-white-10 {
  border-color: rgba(255, 255, 255, 0.1) !important;
}

.footer-link {
  transition: all 0.3s ease;
}

.footer-link:hover {
  color: #ffffff !important;
  padding-left: 5px;
}
</style>
