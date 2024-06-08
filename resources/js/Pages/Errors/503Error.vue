<script setup>

defineProps({
  message: {
    type: String,
    default: 'サービスが一時的に利用不可です。'
  }
})
</script>

<template>
  <ErrorLayout title="503 Error" :message="message">
    <template #title>
      <img src="/storage/images/ResponseCode/503 ServiceUnavailable.png" alt="503 Error">
    </template>
  </ErrorLayout>
</template>

