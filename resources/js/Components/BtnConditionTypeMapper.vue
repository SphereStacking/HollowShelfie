<script setup>
import { ItemsConfig } from '@/config'

const props = defineProps({
  type: {
    type: String,
    required: true
  },
})

const getButtonClassForType = (type) => ItemsConfig[type]?.buttonClass || ItemsConfig.default.buttonClass
</script>

<template>
  <button
    class="group btn btn-xs inline-flex cursor-pointer items-center rounded-md text-sm font-medium"
    :class="getButtonClassForType(type)">
    <slot></slot>
  </button>
</template>
