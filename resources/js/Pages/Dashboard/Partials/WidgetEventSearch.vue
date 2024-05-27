<script setup>
import { usePage } from '@inertiajs/vue3'

defineProps({
})

const title = 'Event search'
const iconType = 'search'
const routeUrl = route('event.search.index')
</script>
<template>
  <div class="card bg-base-200 text-center shadow-md">
    <div class="card-body">
      <div class="card-title">
        <IconTypeMapper :type="iconType" />
        {{ title }}
      </div>
      <p class="text-sm">
        {{ count }}
      </p>
      <div class="card-actions justify-end">
        <a class="btn btn-neutral btn-sm" :href="routeUrl">
          Search
        </a>
      </div>
    </div>
  </div>
</template>
