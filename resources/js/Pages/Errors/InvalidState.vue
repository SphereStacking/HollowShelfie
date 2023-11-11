<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="max-w-md w-full space-y-8 flex flex-col">
      <h1 class="text-3xl font-bold mb-4 text-center">認証エラー</h1>
      <p class="text-lg text-gray-700 text-center">認証プロセス中に問題が発生しました。もう一度お試しください。</p>
      <Link href="/" class="ml-4 btn">
      戻る
      </Link>
    </div>
  </div>
</template>

