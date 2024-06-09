<script setup>

defineProps({
  isResponsive: {
    type: Boolean,
    default: false,
  },
})
</script>

<template>
  <div class="flex h-full items-center gap-4 " :class="isResponsive ? 'md:flex-row' : 'flex-col'">
    <ApplicationMark class="size-32" />
    <div class=" font-title text-4xl font-black sm:text-7xl">
      <AppName />
    </div>
  </div>
</template>
