<template>
  <div class="flex min-h-screen items-center justify-center bg-gray-50">
    <form
      class="w-full max-w-md bg-white p-8 rounded-lg shadow-md space-y-6"
      @submit.prevent="onRegister"
    >
      <h2 class="text-2xl font-bold text-center">Sign Up</h2>
      <div>
        <label class="block mb-1 font-medium">Fullname</label>
        <Input v-model="fullname" type="text" placeholder="Enter your fullname" required />
      </div>
      <div>
        <label class="block mb-1 font-medium">Email</label>
        <Input v-model="email" type="email" placeholder="Enter your email" required />
      </div>
      <div>
        <label class="block mb-1 font-medium">Phone Number</label>
        <Input v-model="phone_number" type="tel" placeholder="Enter your phone number" required />
      </div>
      <div>
        <label class="block mb-1 font-medium">Address</label>
        <Input v-model="address" type="text" placeholder="Enter your address" required />
      </div>
      <div>
        <label class="block mb-1 font-medium">Password</label>
        <Input v-model="password" type="password" placeholder="Enter your password" required />
      </div>
      <div>
        <label class="block mb-1 font-medium">Confirm Password</label>
        <Input
          v-model="confirmPassword"
          type="password"
          placeholder="Confirm your password"
          required
        />
      </div>
      <Button type="submit" class="w-full">Sign Up</Button>
      <p class="text-center text-sm mt-4">
        Already have an account?
        <router-link to="/login" class="text-blue-600 hover:underline">Login</router-link>
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

const fullname = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')
const phone_number = ref('')
const address = ref('')
const authStore = useAuthStore()
const router = useRouter()

const onRegister = async () => {
  if (password.value !== confirmPassword.value) {
    alert('Passwords do not match')
    return
  }
  const result = await authStore.register({
    full_name: fullname.value,
    email: email.value,
    phone_number: phone_number.value,
    address: address.value,
    password: password.value,
    password_confirmation: confirmPassword.value,
  })

  if (!result.success) {
    alert(result.error)
  }

  if (result && result.success) {
    alert('Register Success!')
    router.push('/')
  }
}
</script>
