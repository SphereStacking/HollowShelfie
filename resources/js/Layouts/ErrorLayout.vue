<script setup>
import { Head, Link} from '@inertiajs/vue3'
import DOMPurify from 'dompurify'

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  message: {
    type: String,
    required: true
  }
})

const sanitizedMessage = DOMPurify.sanitize(props.message)
function goBack() {
  window.history.back()
}
</script>

<template>
  <div>
    <Head :title="title" />

    <div class="min-h-screen bg-base-300 pb-4">
      <NavigationMenu />
      <!-- Page Content -->
      <main class="flex items-center justify-center px-4 py-8">
        <div class="mt-20 flex w-1/2 flex-col items-center justify-center gap-4">
          <h1 class="mb-4 text-center text-3xl font-bold">
            <slot name="title">
              {{ title }}
            </slot>
          </h1>

          <div class="mb-4 text-center text-lg text-base-content">
            <slot name="message">
              <!-- eslint-disable-next-line vue/no-v-html -->
              <div class="prose" v-html="sanitizedMessage"></div>
            </slot>
          </div>
          <div class="flex flex-col gap-4 md:flex-row">
            <Link :href="route('home')" class="btn btn-link w-20">
              ホームへ
            </Link>
            <button class="btn btn-link w-20" @click="goBack">
              戻る
            </button>
          </div>
        </div>
      </main>
    </div>
    <Footer />
  </div>
</template>
