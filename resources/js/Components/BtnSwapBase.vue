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
  onIcon: {
    type: String,
    required: true
  },
  offIcon: {
    type: String,
    required: true
  },
  onColor: {
    type: String,
    default: 'text-pink-400'
  },
  offColor: {
    type: String,
    default: ''
  },
})
</script>
<template>
  <button class="btn btn-xs  px-1">
    <slot name="before"></slot>
    <label class="swap">
      <input type="checkbox" v-model="props.check" class="hidden" />
      <Icon :icon="onIcon" class="swap-on text-lg transition duration-200 " :class="onColor" />
      <Icon :icon="offIcon" class="text-lg swap-off text-base-content " :class="offColor" />
    </label>
    <slot name="after"></slot>
  </button>
</template>
<style lang="">

</style>
