<script setup>
defineProps({
  links: String
})
</script>

<template>
  <div>
    <a v-for="item in links" class="felx-row link flex items-center gap-0.5" :href="item.link">
      <Icon icon="ph:link-bold" />
      {{ item.label }}
    </a>
  </div>
</template>
