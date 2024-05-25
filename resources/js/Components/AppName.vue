<script setup>
import { usePage } from '@inertiajs/vue3'

const appName = computed(() => {
  return usePage().props.config.appName
})
</script>

<template>
  {{ appName }}
</template>

