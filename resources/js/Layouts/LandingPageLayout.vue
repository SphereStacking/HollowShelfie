<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import Banner from '@/Jetstream/Banner.vue'

const page = usePage()
console.log(page.props)

defineProps({
  title: String,
})

</script>

<template>
  <div>
    <Head :title="title" />

    <Banner />

    <div class="min-h-screen bg-base-300 pb-4">
      <NavigationMenu is-landing-page />

      <!-- Page Heading -->
      <header v-if="$slots.header" class="mb-4 bg-base-300 shadow-2xl ">
        <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
          <slot name="header"></slot>
        </div>
      </header>
      <!-- Page Content -->
      <main class="">
        <slot></slot>
      </main>
    </div>
    <Footer />
  </div>
</template>
