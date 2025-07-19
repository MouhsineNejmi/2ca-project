<template>
  <div class="container">
    <div v-if="!isLoading && !isAuthenticated" class="text-center text-lg text-gray-700 mt-10">
      Please <router-link to="/login" class="text-blue-600 hover:underline">login</router-link> to
      view your todos.
    </div>
    <div v-else-if="!isLoading && isAuthenticated">
      <TaskList />
    </div>
    <div v-else class="text-center text-gray-400 mt-10">Loading...</div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'
import TaskList from '@/components/TaskList.vue'

const authStore = useAuthStore()
const isAuthenticated = computed(() => authStore.isAuthenticated)
const isLoading = computed(() => authStore.isLoading)
</script>
