<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  data: String
})

const links = props.data.links
</script>

<template>
  <div class="flex flex-col gap-1">
    <a v-for="item in links" class="felx-row link flex items-center gap-0.5" :href="item.link">
      <Icon icon="ph:link-bold" />
      {{ item.label }}
    </a>
  </div>
</template>
