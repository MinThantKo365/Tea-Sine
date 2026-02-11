<template>
  <div class="login-page min-vh-100 d-flex align-items-center justify-content-center">
    <div class="login-container">
      <!-- Logo Section -->
      <div class="text-center mb-5">
        <img src="/image/logo (2).png" alt="Tea Sine Logo" class="login-logo mb-4" />
        <h1 class="login-title mb-2">Welcome Back</h1>
        <p class="login-subtitle">Sign in to continue to your account</p>
      </div>

      <!-- Login Form Card -->
      <div class="login-card">
        <form @submit.prevent="submit" class="login-form">
          <!-- Email Field -->
          <div class="form-group mb-4">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-wrapper">
              <input
                id="email"
                v-model="form.email"
                type="email"
                autocomplete="email"
                required
                class="form-input"
                placeholder="name@example.com"
              />
            </div>
            <div v-if="errors.email" class="error-message">{{ errors.email }}</div>
          </div>

          <!-- Password Field -->
          <div class="form-group mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrapper position-relative">
              <input
                id="password"
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                autocomplete="current-password"
                required
                class="form-input pe-5"
                placeholder="Enter your password"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="password-toggle"
              >
                {{ showPassword ? 'Hide' : 'Show' }}
              </button>
            </div>
            <div v-if="errors.password" class="error-message">{{ errors.password }}</div>
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="form-options d-flex justify-content-between align-items-center mb-4">
            <label class="checkbox-label">
              <input
                id="remember"
                v-model="form.remember"
                type="checkbox"
                class="checkbox-input"
              />
              <span>Remember me</span>
            </label>
            <a href="#" class="forgot-link">Forgot password?</a>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="processing"
            class="submit-btn w-100"
          >
            <span v-if="processing" class="spinner-border spinner-border-sm me-2"></span>
            {{ processing ? 'Signing in...' : 'Sign In' }}
          </button>
        </form>
      </div>

      <!-- Sign Up Link -->
      <div class="text-center mt-4">
        <p class="signup-text">
          Don't have an account?
          <a href="/register" class="signup-link">Create one now</a>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const showPassword = ref(false)
const processing = computed(() => form.processing)
const errors = computed(() => form.errors)

const submit = () => {
  form.post('/login', {
    preserveScroll: true,
    onSuccess: () => {},
    onError: (errors) => {
      console.log('Login errors:', errors)
    },
  })
}
</script>

<style scoped>
.login-page {
  background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0a0a0a 100%);
  padding: 2rem 1rem;
  position: relative;
  overflow: hidden;
}

/* .login-page::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: 
    radial-gradient(circle at 20% 50%, rgba(100, 116, 139, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 80%, rgba(100, 116, 139, 0.1) 0%, transparent 50%);
  pointer-events: none;
} */

.login-page::after {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: repeating-linear-gradient(
    45deg,
    transparent,
    transparent 2px,
    rgba(100, 116, 139, 0.03) 2px,
    rgba(100, 116, 139, 0.03) 4px
  );
  animation: gridMove 20s linear infinite;
  pointer-events: none;
}

@keyframes gridMove {
  0% { transform: translate(0, 0); }
  100% { transform: translate(50px, 50px); }
}

.login-container {
  width: 100%;
  max-width: 440px;
  position: relative;
  z-index: 1;
}

.login-logo {
  height: 90px;
  width: auto;
  display: block;
  margin: 0 auto;
  filter: drop-shadow(0 4px 12px rgba(255, 255, 255, 0.1));
}

.login-title {
  font-size: 2rem;
  font-weight: 700;
  color: #ffffff;
  letter-spacing: -0.5px;
  margin-bottom: 0.5rem;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.login-subtitle {
  font-size: 1rem;
  color: rgba(255, 255, 255, 0.75);
  font-weight: 400;
  margin: 0;
}

.login-card {
  background: #ffffff;
  border-radius: 24px;
  padding: 2.5rem;
  box-shadow: 0 25px 70px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(148, 163, 184, 0.1);
  position: relative;
  overflow: hidden;
}

.login-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 5px;
  background: linear-gradient(90deg, #64748b 0%, #475569 50%, #64748b 100%);
  border-radius: 24px 24px 0 0;
}

.login-form {
  margin: 0;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 600;
  color: #000000;
  margin-bottom: 0.5rem;
  letter-spacing: 0.3px;
}

.input-wrapper {
  position: relative;
}

.form-input {
  width: 100%;
  padding: 0.875rem 1.25rem;
  font-size: 1rem;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  background: #f8fafc;
  color: #1e293b;
  transition: all 0.3s ease;
  outline: none;
}

.form-input:focus {
  border-color: #64748b;
  box-shadow: 0 0 0 4px rgba(100, 116, 139, 0.1);
  background: #ffffff;
}

.form-input::placeholder {
  color: #999999;
}

.password-toggle {
  position: absolute;
  right: 1rem;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: #64748b;
  font-size: 0.875rem;
  font-weight: 600;
  cursor: pointer;
  padding: 0.25rem 0.5rem;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.password-toggle:hover {
  background: #f1f5f9;
  color: #475569;
}

.error-message {
  color: #dc3545;
  font-size: 0.875rem;
  margin-top: 0.5rem;
  display: block;
}

.form-options {
  margin-bottom: 1.5rem;
}

.checkbox-label {
  display: flex;
  align-items: center;
  cursor: pointer;
  font-size: 0.875rem;
  color: #475569;
  user-select: none;
}

.checkbox-input {
  width: 18px;
  height: 18px;
  margin-right: 0.5rem;
  cursor: pointer;
  accent-color: #64748b;
}

.forgot-link {
  color: #64748b;
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 600;
  transition: all 0.2s ease;
  border-bottom: 2px solid transparent;
}

.forgot-link:hover {
  color: #475569;
  border-bottom-color: #64748b;
}

.submit-btn {
  padding: 0.875rem 1.5rem;
  font-size: 1rem;
  font-weight: 600;
  color: #ffffff;
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  border: 2px solid #334155;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(30, 41, 59, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1);
  letter-spacing: 0.3px;
  position: relative;
  overflow: hidden;
}

.submit-btn::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.15);
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}

.submit-btn:hover:not(:disabled)::before {
  width: 300px;
  height: 300px;
}

.submit-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 25px rgba(30, 41, 59, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.15);
  border-color: #475569;
}

.submit-btn:active:not(:disabled) {
  transform: translateY(0);
}

.submit-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.signup-text {
  color: rgba(255, 255, 255, 0.8);
  font-size: 0.9375rem;
  margin: 0;
}

.signup-link {
  color: #ffffff;
  font-weight: 600;
  text-decoration: none;
  margin-left: 0.5rem;
  transition: all 0.2s ease;
  border-bottom: 2px solid transparent;
}

.signup-link:hover {
  border-bottom-color: #ffffff;
}

/* Responsive */
@media (max-width: 576px) {
  .login-card {
    padding: 2rem 1.5rem;
  }
  
  .login-title {
    font-size: 1.75rem;
  }
  
  .login-logo {
    height: 70px;
  }
}
</style>
