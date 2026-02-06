import { ref } from 'vue'

export function useApi(url, options = {}) {
  const data = ref(null)
  const loading = ref(false)
  const error = ref(null)

  const fetchData = async () => {
    loading.value = true
    error.value = null
    
    try {
      const response = await fetch(url, {
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          ...options.headers,
        },
        ...options,
      })

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }

      data.value = await response.json()
    } catch (err) {
      error.value = err.message
      console.error('API Error:', err)
    } finally {
      loading.value = false
    }
  }

  return {
    data,
    loading,
    error,
    fetchData,
  }
}
