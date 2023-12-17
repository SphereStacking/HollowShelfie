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
  <BtnSwapBase onIcon="material-symbols:thumb-up-rounded" offIcon="material-symbols:thumb-up-outline-rounded"
    :check="props.check">
    <template #after>
      <div v-if="showCount" class="badge badge-xs">{{ count }}</div>
    </template>
  </BtnSwapBase>
</template>
<style lang="">

</style>
