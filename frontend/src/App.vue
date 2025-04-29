<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import { Toaster } from '@/components/ui/sonner'
</script>

<template>
  <Toaster />
  <header>
    <nav class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <div class="sm:ml-6 sm:block">
            <div class="flex space-x-4">
              <RouterLink to="/">Níveis</RouterLink>
              <RouterLink to="/desenvolvedor">Desenvolvedores</RouterLink>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <RouterView />
</template>

<style scoped></style>
