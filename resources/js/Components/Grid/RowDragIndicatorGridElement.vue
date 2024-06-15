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
  <button class="btn btn-square btn-neutral btn-sm items-center justify-center">
    <IconTypeMapper type="drag" class="text-xl" />
  </button>
</template>

<style lang="">
</style>
