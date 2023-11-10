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

const serchTag = (tagName) => {
  router.get(props.route, { tags: [tagName] }, { replace: true, preserveState: true })
}

</script>

<template>
  <div class="badge badge-md" :class="{
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
