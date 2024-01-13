<script setup>
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
  <BtnSwapBase onIcon="mdi:thumb-up" offIcon="mdi:thumb-up-outline"
    :check="props.check">
    <template #after>
      <div v-if="showCount" class="badge badge-xs">{{ count }}</div>
    </template>
  </BtnSwapBase>
</template>
<style lang="">

</style>
