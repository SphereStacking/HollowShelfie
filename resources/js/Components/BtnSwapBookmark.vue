<script setup>
import BtnSwapBase from './BtnSwapBase.vue'

const props = defineProps({
  check: {
    type: Boolean,
    required: true
  },
  count: {
    type: String,
  },
  showCount: {
    type: Boolean,
  },
})
</script>
<template>
  <BtnSwapBase off-icon="offBookmark" on-icon="onBookmark" :check="props.check">
    <template #after>
      <div v-if="showCount" class="badge badge-xs">
        {{ count }}
      </div>
    </template>
  </BtnSwapBase>
</template>
<style lang="">

</style>
