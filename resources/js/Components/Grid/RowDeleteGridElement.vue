<script setup>

import {Icon} from '@iconify/vue'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'

defineProps({
  rowIndex: {
    type: Number,
    default: null
  }
})

const emit = defineEmits(['rowDelete'])
</script>

<template>
  <button class="btn btn-square btn-error  btn-xs" @click="emit('rowDelete',rowIndex)">
    <IconTypeMapper type="delete" class="text-xl " />
  </button>
</template>

<style lang="">
</style>
