<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  name: {
    type: String,
    required: true,
  },
  href: {
    type: String,
    required: true,
  },
  imageUrl: {
    type: String,
    required: true,
  },
  size: {
    type: String,
    default: 'size-20',
  },
})

</script>
<template>
  <Link
    :href="href"
    class="avatar tooltip transition-all duration-200 hover:-translate-y-1"
    :data-tip="name">
    <div class="rounded-xl" :class="size">
      <img :src="imageUrl" class="">
    </div>
  </Link>
</template>
