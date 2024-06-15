<script setup>

defineProps({
  isResponsive: {
    type: Boolean,
    default: false,
  },
})
</script>

<template>
  <div class="flex h-full items-center" :class="isResponsive ? 'md:flex-row' : 'flex-col'">
    <div class="flex flex-col items-center gap-2 px-4">
      <ApplicationMark class="size-32" />
      <div class="font-title text-xl font-black  sm:text-3xl " :class="isResponsive ? 'text-center' : ''">
        Hollow
      </div>
    </div>
    <span class="font-title text-4xl font-black sm:text-8xl">Shelfie</span>
  </div>
</template>
