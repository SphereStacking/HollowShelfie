<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: {
    type: String,
    required: true
  },
  active: {
    type: Boolean,
  }
})

</script>

<template>
  <Link
    :href="href"
    class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none"
    :class="{
      'border-base-content text-base-content  focus:border-base-content ': active,
      'border-transparent text-neutral-content/70 hover:border-base-content hover:text-neutral-content focus:border-base-content focus:text-base-content/70': !active
    }">
    <slot></slot>
  </Link>
</template>
