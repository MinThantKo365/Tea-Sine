<template>
  <header class="navbar-container">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <!-- Logo/Brand -->
        <a class="navbar-brand" href="/home">
          <img src="/image/logo (2).png" alt="Tea Sine Logo" class="brand-logo" />
        </a>

        <!-- Mobile Toggle Button -->
        <button 
          :class="['navbar-toggler', { 'menu-open': isMenuOpen }]"
          type="button" 
          aria-controls="navbarNav" 
          :aria-expanded="isMenuOpen" 
          aria-label="Toggle navigation"
          @click="toggleMobileMenu"
        >
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
        </button>

        <!-- Collapsible Menu -->
        <div :class="['collapse navbar-collapse', { 'show': isMenuOpen }]" id="navbarNav">
          <!-- Navigation Links -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="/home" @click="closeMenu">
                <span class="nav-text">Home</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" @click="closeMenu">
                <span class="nav-text">Tables</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" @click="closeMenu">
                <span class="nav-text">Products</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" @click="closeMenu">
                <span class="nav-text">About</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" @click="closeMenu">
                <span class="nav-text">Contact</span>
              </a>
            </li>
          </ul>

          <!-- User Actions -->
          <div class="user-section">
            <template v-if="auth">
              <div class="user-info">
                <!-- <span class="user-greeting">Welcome,</span> -->
                <span class="user-name">{{ auth.name }}</span>
              </div>
              <button @click="logout" class="action-btn logout-btn">
                <span>Logout</span>
              </button>
            </template>
            <template v-else>
              <a href="/" class="action-btn login-btn">
                <span>Login</span>
              </a>
              <a href="/register" class="action-btn register-btn">
                <span>Register</span>
              </a>
            </template>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

const page = usePage()
const auth = computed(() => page.props.auth?.user)
const isMenuOpen = ref(false)

const toggleMobileMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

const closeMenu = () => {
  if (window.innerWidth <= 991.98) {
    isMenuOpen.value = false
  }
}

const handleClickOutside = (event) => {
  if (window.innerWidth <= 991.98 && isMenuOpen.value) {
    const navbar = document.querySelector('.navbar')
    const toggleButton = document.querySelector('.navbar-toggler')
    if (navbar && !navbar.contains(event.target) && !toggleButton?.contains(event.target)) {
      isMenuOpen.value = false
    }
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})

const logout = () => {
  router.post('/logout')
}
</script>

<style scoped>
/* Main Container */
.navbar-container {
  background: #000000;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  position: sticky;
  top: 0;
  z-index: 1000;
  backdrop-filter: blur(20px);
  box-shadow: 0 2px 30px rgba(0, 0, 0, 0.5);
}

.navbar {
  padding: 0;
  min-height: 80px;
}

.navbar .container-fluid {
  padding: 0 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

/* Logo */
.navbar-brand {
  padding: 0;
  margin: 0;
  display: flex;
  align-items: center;
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.navbar-brand:hover {
  transform: scale(1.08);
}

.brand-logo {
  height: 50px;
  width: auto;
  filter: brightness(1.1) drop-shadow(0 0 10px rgba(255, 255, 255, 0.1));
  transition: filter 0.3s ease;
}

.navbar-brand:hover .brand-logo {
  filter: brightness(1.2) drop-shadow(0 0 15px rgba(255, 255, 255, 0.2));
}

/* Navigation Links */
.navbar-nav {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  margin: 0 auto;
  padding: 0 2rem;
}

.nav-item {
  position: relative;
}

.nav-link {
  color: rgba(255, 255, 255, 0.75) !important;
  font-weight: 500;
  font-size: 0.9rem;
  padding: 0.75rem 1.25rem !important;
  position: relative;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border-radius: 8px;
  text-decoration: none;
  display: block;
  overflow: hidden;
}

.nav-link::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
  opacity: 0;
  transition: opacity 0.3s ease;
  z-index: -1;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 8px;
  left: 50%;
  transform: translateX(-50%);
  width: 0;
  height: 2px;
  background: #ffffff;
  transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  border-radius: 2px;
}

.nav-link:hover {
  color: #ffffff !important;
}

.nav-link:hover::before {
  opacity: 1;
}

.nav-link:hover::after {
  width: 60%;
}

.nav-text {
  position: relative;
  z-index: 1;
}

/* Mobile Toggle Button */
.navbar-toggler {
  border: none;
  padding: 0.5rem;
  background: transparent;
  display: none;
  flex-direction: column;
  gap: 5px;
  cursor: pointer;
  transition: transform 0.3s ease;
}

.navbar-toggler:hover {
  transform: scale(1.1);
}

.navbar-toggler:focus {
  box-shadow: none;
  outline: 2px solid rgba(255, 255, 255, 0.3);
  outline-offset: 4px;
  border-radius: 4px;
}

.hamburger-line {
  width: 25px;
  height: 2.5px;
  background: #ffffff;
  border-radius: 2px;
  transition: all 0.3s ease;
  display: block;
}

.navbar-toggler[aria-expanded="true"] .hamburger-line:nth-child(1),
.navbar-toggler.menu-open .hamburger-line:nth-child(1) {
  transform: rotate(45deg) translate(7px, 7px);
}

.navbar-toggler[aria-expanded="true"] .hamburger-line:nth-child(2),
.navbar-toggler.menu-open .hamburger-line:nth-child(2) {
  opacity: 0;
}

.navbar-toggler[aria-expanded="true"] .hamburger-line:nth-child(3),
.navbar-toggler.menu-open .hamburger-line:nth-child(3) {
  transform: rotate(-45deg) translate(7px, -7px);
}

/* User Section */
.user-section {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-left: auto;
}

.user-info {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 0.1rem;
}

.user-greeting {
  color: rgba(255, 255, 255, 0.5);
  font-size: 0.75rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.user-name {
  color: #ffffff !important;
  font-size: 0.95rem;
  font-weight: 600;
}

/* Action Buttons */
.action-btn {
  padding: 0.65rem 1.75rem;
  font-size: 0.9rem;
  font-weight: 600;
  border-radius: 8px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  border: none;
  position: relative;
  overflow: hidden;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.action-btn span {
  position: relative;
  z-index: 1;
}

.logout-btn,
.login-btn {
  color: #ffffff;
  background: rgba(255, 255, 255, 0.05);
  border: 1.5px solid rgba(255, 255, 255, 0.2);
}

.logout-btn:hover,
.login-btn:hover {
  background: rgba(255, 255, 255, 0.1);
  border-color: rgba(255, 255, 255, 0.4);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 255, 255, 0.1);
}

.register-btn {
  color: #000000;
  background: #ffffff;
  border: 1.5px solid #ffffff;
}

.register-btn:hover {
  background: rgba(255, 255, 255, 0.95);
  transform: translateY(-2px);
  box-shadow: 0 6px 25px rgba(255, 255, 255, 0.3);
  color: #000000;
}

/* Mobile Responsive */
@media (max-width: 991.98px) {
  .navbar .container-fluid {
    margin-top: 10px;
    padding: 0 1.5rem;
  }

  .navbar {
    min-height: 70px;
  }

  .brand-logo {
    height: 42px;
  }

  .navbar-toggler {
    display: flex;
  }

  .navbar-collapse {
    background: #000000;
    margin-top: 0;
    padding: 0;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), 
                padding 0.35s cubic-bezier(0.4, 0, 0.2, 1), 
                margin 0.35s cubic-bezier(0.4, 0, 0.2, 1), 
                opacity 0.3s ease;
    opacity: 0;
  }

  .navbar-collapse.show {
    max-height: 800px;
    margin-top: 1rem;
    padding: 1.5rem;
    opacity: 1;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                padding 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                margin 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                opacity 0.4s ease;
  }

  .navbar-nav {
    flex-direction: column;
    align-items: stretch;
    gap: 0.5rem;
    padding: 0;
    margin-bottom: 1.5rem;
  }

  .nav-link {
    padding: 1rem 1.25rem !important;
    border-radius: 10px;
  }

  .nav-link::after {
    display: none;
  }

  .nav-link:hover {
    background: rgba(255, 255, 255, 0.08);
    padding-left: 1.5rem !important;
  }

  .user-section {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
  }

  .user-info {
    align-items: center;
    text-align: center;
  }

  .action-btn {
    width: 100%;
    justify-content: center;
  }
}

</style>
