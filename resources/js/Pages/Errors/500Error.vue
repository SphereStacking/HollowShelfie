<script setup>

defineProps({
  message: {
    type: String,
    default: 'サーバー内部エラー'
  }
})
</script>

<template>
  <ErrorLayout title="500 Error">
    <template #title>
      500 Error
    </template>
    <template #message>
      {{ message }}
    </template>
  </ErrorLayout>
</template>

