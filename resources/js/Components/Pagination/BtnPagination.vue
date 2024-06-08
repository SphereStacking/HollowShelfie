<script setup>

defineProps({
  links: {
    type: Array,
    required: true
  },
})

</script>

<template>
  <div class="join">
    <PaginationBtnLink
      v-for="(link, index) in links" :key="index" :label="link.label"
      :url="link.url ?? '#'" :active="link.active" />
  </div>
</template>
<style lang="">

</style>
