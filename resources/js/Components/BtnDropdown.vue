<script setup>

const props = defineProps({
  width: {
    type: String,
    default: 'w-52',
  },
  zIndex: {
    type: String,
    default: 'z-10',
  },
})
</script>

<template>
  <div class="dropdown ">
    <div tabindex="0" class="flex items-center justify-center">
      <slot name="trigger">
        <button role="button" class="btn btn-ghost btn-xs p-0">
          <IconTypeMapper type="overflowMenu" class="text-xl" />
        </button>
      </slot>
    </div>

    <ul tabindex="0" class="menu dropdown-content rounded-box border border-neutral bg-base-200 p-2 shadow" :class="[width, zIndex]">
      <slot></slot>
    </ul>
  </div>
</template>

<style scoped>
</style>
