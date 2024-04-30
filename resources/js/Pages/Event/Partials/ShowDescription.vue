<script setup>

defineProps({
  description: {
    type: String,
    required: true
  }
})

</script>
<template>
  <CardArticle>
    <template #content>
      <!-- eslint-disable-next-line vue/no-v-html -->
      <article class=" prose h-full  overflow-y-auto" v-html="description"></article>
    </template>
  </CardArticle>
</template>
<style>

</style>
