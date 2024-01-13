<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: String,
  as: String,
})
</script>

<template>
  <div>
    <button
      v-if="as == 'button'" type="submit"
      class="block w-full px-4 py-2 text-left text-sm leading-5  transition duration-150 ease-in-out hover:bg-base-100 focus:bg-base-200 focus:outline-none">
      <slot></slot>
    </button>

    <a
      v-else-if="as == 'a'" :href="href"
      class="block px-4 py-2 text-sm leading-5  transition duration-150 ease-in-out hover:bg-base-100 focus:bg-base-200 focus:outline-none">
      <slot></slot>
    </a>

    <Link
      v-else :href="href"
      class="block px-4 py-2 text-sm leading-5  transition duration-150 ease-in-out hover:bg-base-100 focus:bg-base-200 focus:outline-none">
      <slot></slot>
    </Link>
  </div>
</template>
