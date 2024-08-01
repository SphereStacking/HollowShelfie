<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import Banner from '@/Jetstream/Banner.vue'
import { GetAppMetaTags } from '@/Modules/MetaTag/metaTagHelpers'
import { isDevelopment } from '@/Utils/Environment'

if (isDevelopment()){
  console.info('props :', usePage().props)
}

defineProps({
  title: {
    type: String,
    default: () => usePage().props.config.appName,
  },
  metaTags: {
    type: Array,
    default: () => GetAppMetaTags(),
  },
  mainClass: {
    type: String,
    default: () => 'px-6 sm:px-12 mt-10',
  },
})

</script>

<template>
  <div>
    <!-- Title -->
    <Head :title="title" />
    <!-- Meta Tags -->
    <MetaTags :meta-tags="metaTags" />
    <!-- Banner -->
    <Banner />
    <div class="min-h-screen bg-base-100 pb-4">
      <!-- Navigation Menu -->
      <NavigationMenu class=" sticky top-0 z-30 " />
      <!-- Page Heading -->
      <header v-if="$slots.header" class="sticky top-0 z-20 bg-base-300 shadow-2xl shadow-emerald-200 ">
        <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8 ">
          <slot name="header"></slot>
        </div>
      </header>
      <header v-if="$slots.fixedHeader" class="sticky top-14 z-20 bg-base-300 shadow-2xl shadow-emerald-200 ">
        <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8 ">
          <slot name="fixedHeader"></slot>
        </div>
      </header>
      <!-- Page Content -->
      <main :class="mainClass">
        <slot></slot>
      </main>
    </div>
    <!-- Footer -->
    <Footer class="mt-10" />
  </div>
</template>
