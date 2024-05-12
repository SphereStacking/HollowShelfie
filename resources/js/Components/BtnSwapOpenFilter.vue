<script setup>
import { ItemsConfig } from '@/icon-mapping.js'

defineProps({
  check: {
    type: Boolean,
    required: true
  },
})

const emit = defineEmits(['update:check'])

const updateCheck = (newCheck) => {
  emit('update:check', newCheck)
}
</script>
<template>
  <BtnSwapBase
    on-icon="close" off-icon="filter"
    :check="check" @update:check="updateCheck">
    <slot></slot>
  </BtnSwapBase>
</template>
<style lang="">

</style>
