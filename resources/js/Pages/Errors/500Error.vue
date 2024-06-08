<script setup>

defineProps({
  message: {
    type: String,
    default: 'サーバー内部エラーが発生しました。'
  }
})
</script>

<template>
  <ErrorLayout title="500 Error" :message="message">
    <template #title>
      <img src="/storage/images/ResponseCode/500 InternalServerError.png" alt="500 Error">
    </template>
  </ErrorLayout>
</template>

