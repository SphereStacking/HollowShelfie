<script setup>
defineProps({
  type: {
    type: String,
    default: 'submit',
  },
})
</script>

<template>
  <button :type="type" class="btn btn-primary btn-sm">
    <slot></slot>
  </button>
</template>
