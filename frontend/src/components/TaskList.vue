<template>
  <div>
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-bold">Your Tasks</h2>
      <Button @click="showCreateTask = true">Create New Task</Button>
    </div>
    <div v-if="localError" class="mb-4 p-3 bg-red-100 text-red-700 rounded">
      {{ localError }}
    </div>
    <ul v-if="tasksStore.tasks.length > 0" class="space-y-2">
      <li
        v-for="task in tasksStore.tasks"
        :key="task.id"
        class="p-4 bg-white rounded shadow flex items-center justify-between"
      >
        <div class="flex items-center gap-3">
          <input type="checkbox" :checked="task.completed" @change="toggleCompletion(task.id)" />
          <span :class="{ 'line-through text-gray-400': task.completed }">{{ task.title }}</span>
        </div>
      </li>
    </ul>
    <div v-else class="text-gray-500">No tasks found.</div>

    <!-- Modal for creating a new task -->
    <div
      v-if="showCreateTask"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30 z-50"
    >
      <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Create Task</h3>
        <form @submit.prevent="createTask">
          <div class="mb-4">
            <label class="block mb-1 font-medium">Title</label>
            <Input v-model="newTaskTitle" type="text" placeholder="Task title" required />
          </div>
          <div v-if="localError" class="mb-2 p-2 bg-red-100 text-red-700 rounded">
            {{ localError }}
          </div>
          <div class="flex justify-end gap-2">
            <Button type="button" @click="showCreateTask = false" class="bg-gray-300 text-gray-800"
              >Cancel</Button
            >
            <Button type="submit">Create</Button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useTasksStore } from '@/stores/tasks'
import Input from './ui/Input.vue'
import Button from './ui/Button.vue'

const authStore = useAuthStore()
const tasksStore = useTasksStore()
const showCreateTask = ref(false)
const newTaskTitle = ref('')
const localError = ref<string | null>(null)

const fetchTasks = async () => {
  localError.value = null
  try {
    await tasksStore.fetchTasks()
  } catch (e) {
    localError.value = tasksStore.error || 'Failed to fetch tasks.'
  }
}

const createTask = async () => {
  localError.value = null
  if (!authStore.currentUser) return
  const result = await tasksStore.createTask({ title: newTaskTitle.value })
  if (result.success) {
    newTaskTitle.value = ''
    showCreateTask.value = false
  } else {
    localError.value = result.error || 'Failed to create task.'
  }
}

const toggleCompletion = async (taskId: number) => {
  localError.value = null
  const result = await tasksStore.toggleTaskCompletion(taskId)
  if (result && result.success === false) {
    localError.value = result.error || 'Failed to update task.'
  }
}

watch(showCreateTask, (val) => {
  if (!val) {
    localError.value = null
  }
})

onMounted(fetchTasks)
</script>
