<script setup>

defineProps({
  description: {
    type: String,
    required: true
  }
})

</script>
<template>
  <div class="flex w-full flex-col  justify-center">
    <div class="rounded-xl bg-base-200 p-5">
      <!-- eslint-disable-next-line vue/no-v-html -->
      <article class=" prose h-full  overflow-y-auto" v-html="description"></article>
    </div>
  </div>
</template>
<style>

</style>
