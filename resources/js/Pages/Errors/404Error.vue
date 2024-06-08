<script setup>
defineProps({
  message: {
    type: String,
    default: 'ページが見つかりませんでした。'
  }
})

</script>

<template>
  <ErrorLayout title="404 Error" :message="message">
    <template #title>
      <img src="/storage/images/ResponseCode/404 NotFound.png" alt="404 Error">
    </template>
  </ErrorLayout>
</template>

