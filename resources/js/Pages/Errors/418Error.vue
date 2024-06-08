<script setup>

defineProps({
  message: {
    type: String,
    default: 'わたしはティーポットです。'
  }
})
</script>

<template>
  <ErrorLayout title="418 Error" :message="message">
    <template #title>
      <img src="/storage/images/ResponseCode/418 I'm a teapot.png" alt="418 Error">
    </template>
  </ErrorLayout>
</template>

