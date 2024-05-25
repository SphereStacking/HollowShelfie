<script setup>

defineProps({
  isResponsive: {
    type: Boolean,
    default: false,
  },
})
</script>

<template>
  <div class="flex h-full items-center gap-4 text-7xl" :class="isResponsive ? 'md:flex-row' : 'flex-col'">
    <ApplicationMark class="size-32" />
    <div class=" font-title font-black">
      <AppName />
    </div>
  </div>
</template>
