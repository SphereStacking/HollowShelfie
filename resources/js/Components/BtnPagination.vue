<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  nextPageUrl: {
    type: String,
    required: true
  },
  prevPageUrl: {
    type: String,
    required: true
  },
  links: {
    type: Array,
    required: true
  },
})

</script>


<template>
  <div class="join">
    <Link v-for="(link, index) in links" :key="index" class="join-item btn btn-sm" :href="link.url"
      :class="{ 'btn-active': link.active }">
    {{ link.label }}
    </Link>
  </div>
</template>
<style lang="">

</style>
