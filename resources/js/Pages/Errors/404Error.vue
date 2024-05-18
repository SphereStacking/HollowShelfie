<script setup>
defineProps({
  message: {
    type: String,
    default: 'ページが見つかりませんでした。'
  }
})

</script>

<template>
  <ErrorLayout title="404 Error" :message="message" />
</template>

