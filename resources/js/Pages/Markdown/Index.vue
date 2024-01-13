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
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-neutral">
      </h2>
    </template>
    <div class="my-6  max-w-7xl">
      <div class="prose mx-auto" v-html="props.content"></div>
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
