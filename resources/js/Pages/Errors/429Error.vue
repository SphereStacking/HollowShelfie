<script setup>

defineProps({
  message: {
    type: String,
    default: 'リクエストが多すぎます。'
  }
})
</script>

<template>
  <ErrorLayout title="429 Error">
    <template #title>
      429 Error
    </template>
    <template #message>
      {{ message }}
    </template>
  </ErrorLayout>
</template>

