<script setup>
import { ref } from 'vue'

const isCollapseOpen = ref(false)

const toggleCollapse = () => {
  isCollapseOpen.value = !isCollapseOpen.value
}
</script>

<template>
  <div class="collapse overflow-visible bg-base-100">
    <input v-model="isCollapseOpen" type="checkbox">
    <div class="collapse-title flex items-center justify-between p-0 text-xl font-medium">
      <div class="w-full cursor-pointer" @click.stop="toggleCollapse">
        <slot name="title"></slot>
      </div>
      <slot name="actions" :toggle-collapse-func="toggleCollapse" :is-collapse-open="isCollapseOpen">
        <button class="btn btn-ghost btn-sm" @click="toggleCollapse">
          <IconTypeMapper type="arrowDown" class="text-xl duration-200" :class="{ 'rotate-180': isCollapseOpen }" />
        </button>
      </slot>
    </div>
    <div class="collapse-content">
      <slot></slot>
    </div>
  </div>
</template>

<style scoped>
</style>
