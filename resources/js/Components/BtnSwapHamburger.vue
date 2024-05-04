<script setup>
import { ItemsConfig } from '@/config.js' // '@/config.js' のパスはプロジェクトの設定によって異なる場合があります。

const props = defineProps({
  check: {
    type: Boolean,
    required: true
  },
  count: {
    type: String,
    default: '?'
  },
})
const onIcon = ItemsConfig.close.icon
const offIcon = ItemsConfig.menu.icon

const emit = defineEmits(['update:check'])

const updateCheck = (newCheck) => {
  emit('update:check', newCheck)
}
</script>
<template>
  <BtnSwapBase
    class="btn btn-square btn-ghost btn-active btn-sm"
    :on-icon="onIcon" :off-icon="offIcon" swap-effect="rotate"
    :check="props.check" on-color="white text-xl" off-color="white text-xl"
    @update:check="updateCheck" />
</template>
<style>

</style>
