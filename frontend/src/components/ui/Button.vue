<template>
  <button
    v-bind="$attrs"
    :type="type"
    class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition font-medium"
  >
    <slot />
  </button>
</template>

<script setup lang="ts">
import { defineProps } from 'vue'

defineProps({
  type: {
    type: String as () => 'button' | 'submit' | 'reset' | undefined,
    default: 'button',
  },
})
</script>
