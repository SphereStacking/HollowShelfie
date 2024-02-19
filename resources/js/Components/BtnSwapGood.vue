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
  showCount: {
    type: Boolean,
  },
})
const onIcon = ItemsConfig.onGood.icon
const offIcon = ItemsConfig.offGood.icon
</script>
<template>
  <BtnSwapBase
    :on-icon="onIcon" :off-icon="offIcon"
    :check="props.check">
    <template #after>
      <div v-if="showCount" class="badge badge-xs">
        {{ count }}
      </div>
    </template>
  </BtnSwapBase>
</template>
<style lang="">

</style>
