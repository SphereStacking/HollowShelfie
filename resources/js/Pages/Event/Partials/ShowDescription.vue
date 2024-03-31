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
      <div class=" prose lg:prose-xl">
        {{ description }}
      </div>
    </template>
  </CardArticle>
</template>
<style>

</style>
