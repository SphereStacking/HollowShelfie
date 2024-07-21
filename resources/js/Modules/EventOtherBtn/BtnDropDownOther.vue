<script setup lang="ts">
import { Good, Bookmark } from './BtnDropDownOtherTypes'

defineProps<{
  eventAlias: string,
  good: Good,
  bookmark: Bookmark
}>()

const emit = defineEmits(['share'])
</script>

<template>
  <BtnDropdown>
    <template #trigger>
      <button class="btn btn-ghost btn-xs p-0">
        <IconTypeMapper type="overflowMenu" class="text-xl" />
      </button>
    </template>
    <BtnDropdownItem>
      <BtnSwapEventGood
        :event-id="eventAlias" :check="!good.isGood"
        show-count />
    </BtnDropdownItem>
    <BtnDropdownItem>
      <button class="btn btn-xs" @click="emit('share')">
        <IconTypeMapper type="share" class="text-xl" />
      </button>
    </BtnDropdownItem>
  </BtnDropdown>
</template>

<style scoped>
</style>
