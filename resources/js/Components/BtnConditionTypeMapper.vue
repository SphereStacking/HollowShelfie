<script setup>
import { ItemsConfig } from '@/config';

const props = defineProps({
  type: {
    type: String,
    required: true
  },
});

const getButtonClassForType = (type) => ItemsConfig[type]?.buttonClass || ItemsConfig.default.buttonClass;
</script>

<template>
  <button class="btn btn-xs rounded-md cursor-pointer inline-flex items-center text-sm font-medium group"
    :class="getButtonClassForType(type)">
    <slot></slot>
  </button>
</template>
