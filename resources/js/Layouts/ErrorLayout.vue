<script setup>
import { Head} from '@inertiajs/vue3'
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

          <Link :href="route('welcome')" class="btn w-40">
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
