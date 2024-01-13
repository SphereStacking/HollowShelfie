<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="flex min-h-screen items-center justify-center px-4 py-8">
    <div class="flex w-full max-w-md flex-col space-y-8">
      <h1 class="mb-4 text-center text-3xl font-bold">
        認証エラー
      </h1>
      <p class="text-center text-lg text-gray-700">
        認証プロセス中に問題が発生しました。もう一度お試しください。
      </p>
      <Link href="/" class="btn ml-4">
        戻る
      </Link>
    </div>
  </div>
</template>

