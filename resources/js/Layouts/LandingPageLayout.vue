<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import Banner from '@/Jetstream/Banner.vue'
import { GetAppMetaTags } from '@/Modules/MetaTag/metaTagHelpers'

defineProps({
  title: {
    type: String,
    default: () => usePage().props.config.appName,
  },
  metaTags: {
    type: Array,
    default: () => GetAppMetaTags(),
  },
})

</script>

<template>
  <div>
    <!-- Title -->
    <Head :title="title" />
    <!-- Meta Tags -->
    <MetaTags :meta-tags="metaTags" />

    <Banner />

    <div class="min-h-screen bg-base-300 pb-4">
      <NavigationMenu is-night-mode />

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
