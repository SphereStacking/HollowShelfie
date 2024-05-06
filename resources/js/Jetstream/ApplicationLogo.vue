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
    <ApplicationMark class="h-32 w-32" />
    <div class=" font-title font-black">
      Ghost Shelfie
    </div>
  </div>
</template>
