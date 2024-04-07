<script setup>
import { ref, watchEffect } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const show = ref(true)
const style = ref('success')
const message = ref('')

watchEffect(async () => {
  style.value = page.props.jetstream.flash?.bannerStyle || 'success'
  message.value = page.props.jetstream.flash?.banner || ''
  show.value = true
})
</script>

<template>
  <div>
    <div v-if="show && message" :class="{ 'bg-info/80': style == 'success', 'bg-error/80': style == 'danger' }">
      <div class="mx-auto max-w-screen-xl px-3 py-2 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between">
          <div class="flex w-0 min-w-0 flex-1 items-center">
            <span class="flex rounded-lg p-2" :class="{ 'bg-info': style == 'success', 'bg-error': style == 'danger' }">
              <svg
                v-if="style == 'success'" class="h-5 w-5 text-info-content" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>

              <svg
                v-if="style == 'danger'" class="h-5 w-5 text-error-content" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
              </svg>
            </span>

            <p class="ml-3 truncate text-sm font-medium" :class="{'text-info-content': style == 'success', 'text-error-content': style == 'danger'}">
              {{ message }}
            </p>
          </div>

          <div class="shrink-0 sm:ml-3">
            <button
              type="button"
              class="btn btn-ghost btn-sm"
              :class="{ 'text-info-content': style == 'success', 'text-error-content': style == 'danger' }"
              aria-label="Dismiss"
              @click.prevent="show = false">
              <svg
                class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
