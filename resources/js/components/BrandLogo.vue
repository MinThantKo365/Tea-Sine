<template>
  <div class="brand-logo-wrap" :class="{ 'brand-logo-wrap--chip': showChip }">
    <img :src="src" :alt="alt" class="brand-logo-img" :style="{ height }" />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useTheme } from '../composables/useTheme'

const props = defineProps({
  src: { type: String, default: '/image/logo (2).png' },
  alt: { type: String, default: 'Tea Sine' },
  height: { type: String, default: '36px' },
  alwaysChip: { type: Boolean, default: false },
})

const { resolvedTheme } = useTheme()

const showChip = computed(() => props.alwaysChip || resolvedTheme.value === 'light')
</script>

<style scoped>
.brand-logo-wrap {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  line-height: 0;
}
.brand-logo-wrap--chip {
  background: var(--ts-brand-navy);
  border-radius: 10px;
  padding: 0.4rem 0.65rem;
}
.brand-logo-img {
  width: auto;
  display: block;
}
</style>
