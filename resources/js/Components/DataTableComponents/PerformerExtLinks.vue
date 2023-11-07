<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  data: String
});

const links = props.data.links
</script>

<template>
  <div class="flex flex-col gap-1">
      <a class="link flex felx-row items-center gap-0.5" :href="item.link"  v-for="item in links">
        <Icon icon="ph:link-bold"></Icon>
        {{ item.label }}
      </a>
  </div>
</template>
