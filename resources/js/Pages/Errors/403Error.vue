<script setup>

defineProps({
  message: {
    type: String,
    default: '権限がありません。'
  }
})

</script>

<template>
  <ErrorLayout title="403 Error">
    <template #title>
      403 Error
    </template>
    <template #message>
      {{ message }}
    </template>
  </ErrorLayout>
</template>

