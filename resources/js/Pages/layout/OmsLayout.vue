<template>
  <div class="oms-layout min-vh-100 d-flex flex-column">
    <header class="navbar-container">
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
          <Link href="/dashboard" class="navbar-brand">
            <img src="/image/logo (2).png" alt="Tea Sine" class="brand-logo" />
          </Link>
          <button
            :class="['navbar-toggler', { 'menu-open': isMenuOpen }]"
            type="button"
            @click="isMenuOpen = !isMenuOpen"
          >
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
          </button>
          <div :class="['collapse navbar-collapse', { show: isMenuOpen }]">
            <ul class="navbar-nav me-auto">
              <template v-if="roleName === 'admin'">
                <li class="nav-item"><Link class="nav-link" href="/admin/dashboard" @click="closeMenu">Dashboard</Link></li>
                <li class="nav-item"><Link class="nav-link" href="/admin/menu-items" @click="closeMenu">Menu</Link></li>
                <li class="nav-item"><Link class="nav-link" href="/admin/orders" @click="closeMenu">Orders</Link></li>
                <li class="nav-item"><Link class="nav-link" href="/admin/payments" @click="closeMenu">Payments</Link></li>
                <li class="nav-item"><Link class="nav-link" href="/admin/staff" @click="closeMenu">Staff</Link></li>
                <li class="nav-item"><Link class="nav-link" href="/admin/payslips" @click="closeMenu">Payslips</Link></li>
              </template>
              <template v-else-if="roleName === 'cashier'">
                <li class="nav-item"><Link class="nav-link" href="/cashier/orders/create" @click="closeMenu">New Order</Link></li>
                <li class="nav-item"><Link class="nav-link" href="/cashier/orders" @click="closeMenu">Orders</Link></li>
                <li class="nav-item"><Link class="nav-link" href="/cashier/payments" @click="closeMenu">Payments</Link></li>
              </template>
              <template v-else-if="roleName === 'cook'">
                <li class="nav-item"><Link class="nav-link" href="/cook/orders" @click="closeMenu">Kitchen</Link></li>
              </template>
              <template v-else-if="roleName === 'staff'">
                <li class="nav-item"><Link class="nav-link" href="/staff/payslips" @click="closeMenu">My Payslips</Link></li>
              </template>
            </ul>
            <div class="user-section">
              <span class="user-name">{{ auth?.name }}</span>
              <span class="badge bg-secondary ms-1">{{ auth?.role?.display_name || 'User' }}</span>
              <button type="button" @click="logout" class="btn btn-outline-light btn-sm ms-2">Logout</button>
            </div>
          </div>
        </div>
      </nav>
    </header>
    <main class="flex-grow-1 py-4">
      <div class="container-fluid">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { usePage, Link, router } from '@inertiajs/vue3'
// Link is used in template

const page = usePage()
const auth = computed(() => page.props.auth?.user)
const roleName = computed(() => auth.value?.role?.name || '')
const isMenuOpen = ref(false)

function closeMenu() {
  isMenuOpen.value = false
}

function logout() {
  router.post('/logout')
}
</script>

<style scoped>
.navbar-container {
  background: #0a0a0a;
  border-bottom: 1px solid rgba(255,255,255,0.08);
  position: sticky;
  top: 0;
  z-index: 1000;
}
.navbar { min-height: 64px; }
.brand-logo { height: 40px; width: auto; }
.nav-link {
  color: rgba(255,255,255,0.8) !important;
  padding: 0.5rem 1rem !important;
  text-decoration: none;
  border-radius: 6px;
}
.nav-link:hover { color: #fff !important; background: rgba(255,255,255,0.08); }
.user-section { display: flex; align-items: center; }
.user-name { color: #fff; font-size: 0.9rem; }
.navbar-toggler {
  border: 1px solid rgba(255,255,255,0.3);
  padding: 0.35rem 0.5rem;
}
.navbar-toggler .hamburger-line {
  width: 20px; height: 2px; background: #fff; display: block; margin: 4px 0; border-radius: 1px;
}
</style>
