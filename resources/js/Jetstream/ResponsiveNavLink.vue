<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  active: Boolean,
  href: {
    type: String,
    default: '#',
  },
})

</script>

<template>
  <Link
    :href="href"
    class="btn btn-ghost no-animation btn-sm btn-block justify-start  rounded-none"
    :class="{ 'btn-active': active }">
    <slot></slot>
  </Link>
</template>
