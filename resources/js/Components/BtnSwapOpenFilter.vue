<script setup>
import { ItemsConfig } from '@/icon-mapping.js'

defineProps({
  check: {
    type: Boolean,
    required: true
  },
})
const onIcon = ItemsConfig.close.icon
const offIcon = ItemsConfig.filter.icon

const emit = defineEmits(['update:check'])

const updateCheck = (newCheck) => {
  emit('update:check', newCheck)
}
</script>
<template>
  <BtnSwapBase
    :on-icon="onIcon" :off-icon="offIcon"
    :check="check" @update:check="updateCheck">
    <slot></slot>
  </BtnSwapBase>
</template>
<style lang="">

</style>
