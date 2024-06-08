<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: {
    type: String,
    default: '#'
  },
  as: {
    type: String,
    default: 'a'
  },

})
</script>

<template>
  <Link
    :href="href"
    class="btn btn-ghost no-animation btn-sm btn-block justify-start rounded-none">
    <slot></slot>
  </Link>
</template>
