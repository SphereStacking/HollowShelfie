<script setup>
import { defineProps } from 'vue'
import { ItemsConfig } from '@/icon-mapping'

defineProps({
  type: {
    type: String,
    required: true
  },
})

const getIconForType = (type) => ItemsConfig[type]?.icon || ItemsConfig.default.icon
const getColorForType = (type) => ItemsConfig[type]?.color || ItemsConfig.default.color
</script>

<template>
  <Icon :icon="getIconForType(type)" :color="getColorForType(type)" />
</template>

