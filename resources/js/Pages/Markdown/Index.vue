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
    <div class="max-w-7xl  my-6">
      <div class="mx-auto prose" v-html="props.content"></div>
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
