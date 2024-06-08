<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  label: {
    type: String,
    required: true
  },
  url: {
    type: String,
    required: true,
  },
  active: {
    type: Boolean,
    required: true
  }
})

const url = computed(() => props.url ?? '#')
</script>

<template>
  <Link class="btn join-item btn-sm" :href="url" :class="{ 'btn-active': active }">
    {{ label }}
  </Link>
</template>
<style lang="">

</style>
