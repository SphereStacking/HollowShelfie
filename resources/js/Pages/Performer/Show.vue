<script setup>
defineProps({
  performer: {
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
        Performer詳細情報
      </h2>
    </template>
    {{ performer }}
  </AppLayout>
</template>
<style lang="">

</style>
