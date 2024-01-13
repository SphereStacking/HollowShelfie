<script setup>
defineProps({
  type: {
    type: String,
    default: 'button',
  },
})
</script>

<template>
  <button :type="type" class="btn btn-secondary btn-sm">
    <slot></slot>
  </button>
</template>
