<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  content: {
    type: Object,
    required: true
  },
})
defineEmits(
  ['click']
)

</script>
<template>
  <AppLayout :title="title">
    <div class="my-6  max-w-7xl">
      <div class="prose mx-auto" v-html="props.content"></div>
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
