<script setup>
defineProps({
  type: {
    type: String,
    default: 'button',
  },
})
</script>

<template>
  <button :type="type" class="btn btn-primary btn-sm ">
    <slot></slot>
  </button>
</template>
