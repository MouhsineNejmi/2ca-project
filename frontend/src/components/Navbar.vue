<template>
  <nav class="flex items-center justify-between px-8 py-3 border-b bg-background">
    <router-link to="/" class="flex items-center gap-2">
      <slot name="logo">
        <span class="font-bold text-lg">Todo list</span>
      </slot>
    </router-link>
    <ul class="flex items-center gap-6">
      <template v-if="user">
        <router-link to="/notifications" class="font-medium hover:underline"
          >Notifications</router-link
        >
        <li class="flex items-center gap-2">
          <Avatar>
            <AvatarImage v-if="user.image" :src="user.image" />
            <AvatarFallback>{{ user.full_name[0] }}</AvatarFallback>
          </Avatar>
          <span class="font-medium">{{ user.full_name }}</span>
        </li>
      </template>
      <template v-else>
        <router-link class="font-medium hover:underline" to="/login">Login</router-link>
        <router-link class="font-medium hover:underline" to="/register">Register</router-link>
      </template>
      <slot />
    </ul>
  </nav>
</template>

<script setup lang="ts">
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar'

interface User {
  full_name: string
  image?: string
}
defineProps<{
  user?: User | null
}>()
</script>
