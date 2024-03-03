<script setup>
import { ItemsConfig } from '@/config.js' // '@/config.js' のパスはプロジェクトの設定によって異なる場合があります。

const props = defineProps({
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
    :check="props.check" @update:check="updateCheck">
    <slot></slot>
  </BtnSwapBase>
</template>
<style lang="">

</style>
