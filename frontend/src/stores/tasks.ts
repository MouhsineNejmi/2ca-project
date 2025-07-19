// stores/tasks.js
import { defineStore } from 'pinia'
import axios from 'axios'

export type CreateTaskData = {
  title: string
  completed?: boolean // optional, defaults to false if not provided
}

export type UpdateTaskData = {
  title?: string
  completed?: boolean
}

export type Task = {
  id: number
  title: string
  completed: boolean
  user_id: number
  created_at?: string
  updated_at?: string
}

const API_URL = `${import.meta.env.VITE_API_URL}`

export const useTasksStore = defineStore('tasks', {
  state: () => ({
    tasks: [] as Task[],
    currentTask: null as Task | null,
    isLoading: false,
    error: null as string | null,
  }),

  getters: {
    completedTasks: (state): Task[] => state.tasks.filter((task) => task.completed),
    pendingTasks: (state): Task[] => state.tasks.filter((task) => !task.completed),
  },

  actions: {
    /**
     * Fetch all tasks for current user
     */
    async fetchTasks() {
      this.isLoading = true
      this.error = null

      try {
        const response = await axios.get(`${API_URL}/tasks`, { withCredentials: true })

        this.tasks = response.data
      } catch (error: any) {
        this.error = error.response?.data?.message || 'Failed to fetch tasks'
        console.error('Fetch tasks error:', error)
      } finally {
        this.isLoading = false
      }
    },

    /**
     * Create a new task
     */
    async createTask(taskData: CreateTaskData) {
      this.isLoading = true
      this.error = null

      try {
        const response = await axios.post(`${API_URL}/tasks`, taskData, { withCredentials: true })
        this.tasks.unshift(response.data)
        return { success: true, task: response.data }
      } catch (error: any) {
        this.error = error.response?.data?.message || 'Failed to create task'
        return { success: false, error: this.error }
      } finally {
        this.isLoading = false
      }
    },

    /**
     * Update an existing task
     */
    async updateTask(taskId: number, updates: UpdateTaskData) {
      this.isLoading = true
      this.error = null

      try {
        const response = await axios.put(`${API_URL}/tasks/${taskId}`, updates, {
          withCredentials: true,
        })
        const index = this.tasks.findIndex((task) => task.id === taskId)

        if (index !== -1) {
          this.tasks[index] = response.data
        }

        return { success: true, task: response.data }
      } catch (error: any) {
        this.error = error.response?.data?.message || 'Failed to update task'
        return { success: false, error: this.error }
      } finally {
        this.isLoading = false
      }
    },

    /**
     * Delete a task
     */
    async deleteTask(taskId: number) {
      this.isLoading = true
      this.error = null

      try {
        await axios.delete(`${API_URL}/tasks/${taskId}`, { withCredentials: true })
        this.tasks = this.tasks.filter((task) => task.id !== taskId)
        return { success: true }
      } catch (error: any) {
        this.error = error.response?.data?.message || 'Failed to delete task'
        return { success: false, error: this.error }
      } finally {
        this.isLoading = false
      }
    },

    /**
     * Toggle task completion status
     */
    async toggleTaskCompletion(taskId: number) {
      const task = this.tasks.find((t) => t.id === taskId)
      if (!task) return

      return await this.updateTask(taskId, { completed: !task.completed })
    },
  },
})
