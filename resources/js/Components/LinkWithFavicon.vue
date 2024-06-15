<script setup>
import { ref, } from 'vue'
import { getFaviconUrl } from '@/Utils/apis/google/favicon'

defineProps({
  link: {
    type: Object,
    required: true
  }
})

</script>

<template>
  <a :href="link.link" class="fel-row link flex items-center gap-0.5">
    <img :src="getFaviconUrl(link.link)" alt="favicon" class="mr-1 size-4">
    {{ link.label }}
  </a>
</template>

<style scoped>
</style>
