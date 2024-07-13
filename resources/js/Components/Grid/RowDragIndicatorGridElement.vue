<script setup>

import IconTypeMapper from '@/Components/IconTypeMapper.vue'

defineProps({
  rowIndex: {
    type: Number,
    default: null
  }
})

</script>

<template>
  <button class="handle btn btn-square btn-neutral btn-xs items-center justify-center">
    <IconTypeMapper type="drag" class="text-xl" />
  </button>
</template>

<style lang="">
</style>
