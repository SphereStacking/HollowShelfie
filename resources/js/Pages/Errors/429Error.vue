<script setup>

defineProps({
  message: {
    type: String,
    default: 'リクエストが多すぎます。'
  }
})
</script>

<template>
  <ErrorLayout title="429 Error" :message="message" />
</template>

