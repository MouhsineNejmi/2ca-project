// stores/auth.js
import { defineStore } from 'pinia'
import axios from 'axios'

export type User = {
  id: number
  full_name: string
  email: string
  phone_number: string
  address?: string
  image?: string
}

export type RegisterUserData = {
  full_name: string
  email: string
  phone_number?: string
  address?: string
  image?: string
  password: string
  password_confirmation: string
}

const API_URL = `${import.meta.env.VITE_API_URL}`

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as User | null,
    isLoading: false,
    error: null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.user,
    currentUser: (state) => state.user,
  },

  actions: {
    /**
     * Register a new user
     */
    async register(userData: RegisterUserData) {
      this.isLoading = true
      this.error = null

      try {
        await axios.post(`${API_URL}/auth/register`, userData, {
          withCredentials: true,
        })

        // After registration, fetch user info
        await this.fetchUser()
        return { success: true, user: this.user }
      } catch (error: any) {
        this.error = error.response?.data?.message || 'Registration failed'
        return { success: false, error: this.error }
      } finally {
        this.isLoading = false
      }
    },

    /**
     * Login user
     */
    async login(credentials: { email: string; password: string }) {
      this.isLoading = true
      this.error = null

      try {
        await axios.post(`${API_URL}/auth/login`, credentials, {
          withCredentials: true,
        })

        // After login, fetch user info
        await this.fetchUser()
        return { success: true, user: this.user }
      } catch (error: any) {
        this.error = error.response?.data?.message || 'Login failed'
        return { success: false, error: this.error }
      } finally {
        this.isLoading = false
      }
    },

    /**
     * Fetch current user info (after login/register or on app load)
     */
    async fetchUser() {
      try {
        const { data } = await axios.get(`${API_URL}/user`, { withCredentials: true })
        this.user = data
      } catch (error) {
        this.user = null
      }
    },

    /**
     * Check authentication status
     */
    async checkAuth() {
      await this.fetchUser()
    },

    logout() {
      this.user = null
    },
  },
})
