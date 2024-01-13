<script setup>
defineProps({
  class: {
    type: String,
    required: true
  }
})
defineEmits(
  ['click']
)
</script>
<template>
  <button>
    <slot></slot>
  </button>
</template>
<style lang="">

</style>
