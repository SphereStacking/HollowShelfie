<script setup>
const props = defineProps({
  check: {
    type: Boolean,
    required: true
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
  swapEffect: {
    type: String,
    default: '',
    validator: value => ['rotate', 'flip', ''].includes(value),
  }
})

const computedSwapEffectClass = computed(() => {
  switch (props.swapEffect) {
  case 'rotate':
    return 'swap-rotate'
  case 'flip':
    return 'swap-flip'
  default:
    return 'swap-flip'
  }
})
const check = ref(props.check)
const emit = defineEmits(['update:check'])
watch(() => check.value, (value) => {
  emit('update:check', value)
})
</script>
<template>
  <button class="btn btn-xs px-1" @click="check = !check">
    <slot name="before"></slot>
    <label class="swap" :class="[computedSwapEffectClass, check ? 'swap-active' : '']">
      <Icon :icon="onIcon" class="swap-on text-lg transition duration-200" :class="onColor" />
      <Icon :icon="offIcon" class="swap-off text-lg text-base-content" :class="offColor" />
    </label>
    <slot></slot>
    <slot name="after"></slot>
  </button>
</template>
<style lang="">

</style>
