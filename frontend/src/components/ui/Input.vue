<template>
  <input
    v-bind="$attrs"
    :type="type"
    :value="modelValue"
    @input="onInput"
    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
  />
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'

defineProps({
  modelValue: String,
  type: {
    type: String,
    default: 'text',
  },
})

const emit = defineEmits(['update:modelValue'])

function onInput(event: Event) {
  const target = event.target as HTMLInputElement | null
  if (target) {
    emit('update:modelValue', target.value)
  }
}
</script>
