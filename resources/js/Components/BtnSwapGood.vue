<script setup>
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
</script>
<template>
  <BtnSwapBase
    on-icon="onGood" off-icon="offGood"
    :check="props.check">
    <template #after>
      <div v-if="showCount" class="badge badge-xs ">
        {{ count }}
      </div>
    </template>
  </BtnSwapBase>
</template>
<style lang="">

</style>
