<script setup>
defineProps({
  type: {
    type: String,
    default: 'button',
  },
})
</script>

<template>
  <button :type="type" class="btn btn-error btn-sm">
    <slot></slot>
  </button>
</template>
