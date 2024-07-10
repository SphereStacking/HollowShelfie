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
const getRotateForType = (type) => ItemsConfig[type]?.class || ItemsConfig.default.class
</script>

<template>
  <Icon :icon="getIconForType(type)" :color="getColorForType(type)" :class="getRotateForType(type)" />
</template>

