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
</script>

<template>
  <Icon :icon="getIconForType(type)" />
</template>

