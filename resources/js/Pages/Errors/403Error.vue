<script setup>

defineProps({
  message: {
    type: String,
    default: '権限がありません。'
  }
})

</script>

<template>
  <ErrorLayout title="403 Error" :message="message">
    <template #title>
      <img src="/storage/images/ResponseCode/403 Forbidden.png" alt="403 Error">
    </template>
  </ErrorLayout>
</template>

