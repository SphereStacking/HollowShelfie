<script setup>
defineProps({
  organizer: {
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
        オーガナイザー詳細
      </h2>
    </template>
    {{ organizer }}
  </AppLayout>
</template>
<style lang="">

</style>
