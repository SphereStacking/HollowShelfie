<script setup>

defineProps({
  message: {
    type: String,
    default: 'サーバー内部エラー'
  }
})
</script>

<template>
  <ErrorLayout title="500 Error" :message="message" />
</template>

