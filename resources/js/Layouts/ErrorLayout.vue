<script setup>
import { Head} from '@inertiajs/vue3'

defineProps({
  title: String,
})

</script>

<template>
  <div>
    <Head :title="title" />

    <div class="min-h-screen bg-base-300 pb-4">
      <NavigationMenu />
      <!-- Page Content -->
      <main class="flex items-center justify-center px-4 py-8">
        <div class="mt-20 flex w-80 flex-col items-center justify-center gap-4">
          <h1 class="mb-4 text-center text-3xl font-bold">
            <slot name="title"></slot>
          </h1>

          <div class="mb-4 text-center text-lg text-base-content ">
            <slot name="message"></slot>
          </div>

          <Link href="/" class="btn w-40">
            ホーム
          </Link>
          <button class="btn w-40" @click="goBack">
            戻る
          </button>
        </div>
      </main>
    </div>
    <Footer />
  </div>
</template>
