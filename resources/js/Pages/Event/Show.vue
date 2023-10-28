<script setup>
defineProps({
  event: {
    type: String,
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
        イベント詳細
      </h2>
    </template>

    <CardEventShow class="mx-auto mt-10 flex max-w-7xl flex-col gap-5" event="event"></CardEventShow>
  </AppLayout>
</template>
<style lang="">

</style>
