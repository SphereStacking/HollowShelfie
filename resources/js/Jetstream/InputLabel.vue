<script setup>
defineProps({
  value: String,
})
</script>

<template>
  <label class="block text-sm font-medium ">
    <span v-if="value">{{ value }}</span>
    <span v-else>
      <slot></slot>
    </span>
  </label>
</template>
