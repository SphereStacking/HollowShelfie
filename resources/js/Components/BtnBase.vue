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
  <button :class="class" @click="$emit('click')">
    <slot></slot>
  </button>
</template>
<style lang="">

</style>
