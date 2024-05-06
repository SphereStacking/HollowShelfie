<script setup>

defineProps({
  message: {
    type: String,
    default: 'ページが見つかりませんでした。'
  }
})

</script>

<template>
  <ErrorLayout title="404 Error">
    <template #title>
      404 Error
    </template>
    <template #message>
      {{ message }}
    </template>
  </ErrorLayout>
</template>

