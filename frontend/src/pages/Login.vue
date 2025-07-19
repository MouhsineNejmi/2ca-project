<template>
  <div class="flex min-h-screen items-center justify-center bg-gray-50">
    <form
      class="w-full max-w-md bg-white p-8 rounded-lg shadow-md space-y-6"
      @submit.prevent="onLogin"
    >
      <h2 class="text-2xl font-bold text-center">Sign In</h2>
      <div>
        <label class="block mb-1 font-medium">Email</label>
        <Input v-model="email" type="email" placeholder="Enter your email" required />
      </div>
      <div>
        <label class="block mb-1 font-medium">Password</label>
        <Input v-model="password" type="password" placeholder="Enter your password" required />
      </div>
      <Button type="submit" class="w-full">Login</Button>
      <p class="text-center text-sm mt-4">
        Don't have an account?
        <router-link to="/register" class="text-blue-600 hover:underline">Register</router-link>
      </p>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'
import Input from '../components/ui/Input.vue'
import Button from '../components/ui/Button.vue'

const email = ref('')
const password = ref('')
const authStore = useAuthStore()
const router = useRouter()

const onLogin = async () => {
  const { success, error } = await authStore.login({ email: email.value, password: password.value })
  if (success) {
    router.push('/')
  }

  if (!success && error) {
    console.error('ERROR: ', error)
    alert(error)
  }
}
</script>
