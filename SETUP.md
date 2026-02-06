# TeaSine - Laravel + Vue 3 Project

A modern, full-stack web application built with **Laravel** backend and **Vue 3** frontend.

## 🚀 Quick Start

### Prerequisites
- Node.js 18+ and npm
- PHP 8.1+
- Composer
- Laravel CLI (optional)

### Installation

1. **Install PHP Dependencies**
   ```bash
   composer install
   ```

2. **Install JavaScript Dependencies**
   ```bash
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup** (if needed)
   ```bash
   php artisan migrate
   ```

### Development

**Start the development server (two terminals):**

Terminal 1 - Run Laravel:
```bash
php artisan serve
```

Terminal 2 - Run Vite:
```bash
npm run dev
```

The application will be available at `http://localhost:8000`

### Production Build

```bash
npm run build
```

This compiles your Vue components and CSS using Vite, optimizing assets for production.

---

## 📁 Project Structure

```
resources/
├── js/
│   ├── app.js                 # Entry point - initializes Vue app
│   ├── bootstrap.js           # Axios configuration
│   ├── components/            # Reusable Vue components
│   │   ├── App.vue           # Root component
│   │   ├── WelcomeCard.vue
│   │   ├── StatsCard.vue
│   │   └── Counter.vue       # Demo component with state
│   ├── composables/           # Reusable logic hooks
│   │   └── useApi.js         # API composable
│   ├── stores/               # Pinia stores (for state management)
│   └── utils/                # Helper utilities
├── css/
│   └── app.css              # Tailwind + custom styles
└── views/
    └── welcome.blade.php     # Main Laravel template

app/
├── Http/
│   └── Controllers/          # API controllers
├── Models/                   # Eloquent models
└── Providers/
```

---

## 🎨 Styling

This project uses **Tailwind CSS v4** with dark mode support. Dark mode is toggled via the `.dark` class on the `html` element.

### Tailwind Configuration
- Located in `tailwind.config.js`
- Configured for content in `resources/**/*.{blade.php,js,vue}`
- Dark mode uses the `class` strategy

---

## 📦 Key Dependencies

### Frontend
- **Vue 3** - Progressive JavaScript framework
- **Tailwind CSS 4** - Utility-first CSS framework
- **Axios** - HTTP client for API requests
- **Vite** - Fast build tool

### Backend
- **Laravel** - PHP web framework
- **Composer** - PHP dependency manager

---

## 🛠️ Creating New Components

### Example: Create a new Vue component

**File: `resources/js/components/MyComponent.vue`**
```vue
<template>
  <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold mb-4">{{ title }}</h2>
    <p>{{ message }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const title = ref('My Component')
const message = ref('Hello from Vue!')
</script>
```

Then import it in `App.vue`:
```vue
import MyComponent from './MyComponent.vue'
```

---

## 🌐 API Integration

Use the `useApi` composable to fetch data from your Laravel backend:

```vue
<script setup>
import { useApi } from '../composables/useApi'

const { data, loading, error, fetchData } = useApi('/api/items')

onMounted(() => {
  fetchData()
})
</script>
```

---

## 🔧 Useful Commands

```bash
# Laravel commands
php artisan tinker              # Interactive shell
php artisan make:controller     # Generate controller
php artisan make:model          # Generate model
php artisan migrate             # Run migrations
php artisan queue:work          # Start queue worker

# Vue/Node commands
npm install                     # Install dependencies
npm run dev                     # Start development server
npm run build                   # Build for production
npm run lint                    # Lint JavaScript (if configured)
```

---

## 📚 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vue 3 Documentation](https://vuejs.org)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Vite Documentation](https://vitejs.dev)

---

## 📝 Notes

- The project is configured with **Vite** for fast HMR (Hot Module Replacement)
- **Tailwind CSS v4** uses the new `@import` syntax
- **Vue 3** uses the Composition API with `<script setup>` syntax
- CSRF protection is configured via the `X-Requested-With` header in `bootstrap.js`

---

## ⚡ Next Steps

1. Create API routes in `routes/api.php`
2. Build controllers in `app/Http/Controllers/Api/`
3. Create Vue components in `resources/js/components/`
4. Set up Pinia stores in `resources/js/stores/` for complex state
5. Configure environment variables in `.env`

Happy coding! 🎉
