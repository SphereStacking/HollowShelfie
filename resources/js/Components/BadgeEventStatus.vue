<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
  status: {
    type: Array,
    required: true
  },
  label: {
    type: String,
    required: true
  }
})

</script>

<template>
  <div class="badge badge-xs" :class="{
    'badge-neutral': status == 'draft',
    'badge-info': status == 'upcoming' || status == 'closed',
    'badge-error': status == 'canceled' || status == 'deleted',
    'badge-success': status == 'ongoing',
  }">
    {{ label }}
  </div>
</template>

<style lang="">

</style>
