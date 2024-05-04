<script setup>
const props = defineProps({
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
  <AppLayout title="Dashboard">
    <div class="my-6  max-w-7xl">
      <div class="prose mx-auto" v-html="props.content"></div>
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
