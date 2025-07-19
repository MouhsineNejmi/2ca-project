<template>
  <div class="container mx-auto space-y-2">
    <h1 class="text-2xl font-bold mb-4">Notifications</h1>

    <div
      v-for="notification in notifications"
      :key="notification.id"
      class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3 max-w-sm"
    >
      <CheckCircle class="w-5 h-5" />
      <div>
        <p class="font-medium">{{ notification.title }}</p>
        <p class="text-sm opacity-90">{{ notification.message }}</p>
      </div>
      <button
        @click="removeNotification(notification.id)"
        class="ml-auto text-white hover:text-gray-200"
      >
        <X class="w-4 h-4" />
      </button>
    </div>

    <div v-if="notifications.length === 0" class="text-gray-500">No notifications yet.</div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { CheckCircle, X } from 'lucide-vue-next'
import { useAuthStore } from '@/stores/auth'
import echo from '@/utils/echo'

const authStore = useAuthStore()

interface Notification {
  id: number
  title: string
  message: string
}

const notifications = ref<Notification[]>([])
let echoChannel: { stopListening: (event: string) => void } | null = null

const addNotification = (notification: Omit<Notification, 'id'>) => {
  const id = Date.now()
  notifications.value.push({
    id,
    ...notification,
  })
  setTimeout(() => {
    removeNotification(id)
  }, 5000)
}

const removeNotification = (id: number) => {
  notifications.value = notifications.value.filter((n) => n.id !== id)
}

function setupEcho() {
  if (echoChannel) {
    echoChannel.stopListening('task.created')
  }
  if (authStore.isAuthenticated && authStore.currentUser) {
    echoChannel = echo
      .private(`tasks.${authStore.currentUser.id}`)
      .listen('task.created', (event: { message: string }) => {
        addNotification({
          title: 'Task Created',
          message: event.message,
        })
      })
  }
}

onMounted(() => {
  setupEcho()
  watch(
    () => authStore.currentUser,
    () => {
      setupEcho()
    },
    { immediate: true },
  )
})

onUnmounted(() => {
  if (echoChannel) {
    echoChannel.stopListening('task.created')
  }
})
</script>
