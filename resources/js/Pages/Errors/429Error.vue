<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  message: {
    type: String,
    default: 'リクエストが多すぎます。'
  }
})
</script>

<template>
  <div class="flex min-h-screen items-center justify-center px-4 py-8">
    <div class="flex w-full max-w-md flex-col space-y-8">
      <h1 class="mb-4 text-center text-3xl font-bold">
        429
      </h1>
      <p class="0 text-center text-lg">
        {{ message }}
      </p>
      <Link href="/" class="btn ml-4">
        戻る
      </Link>
    </div>
  </div>
</template>

