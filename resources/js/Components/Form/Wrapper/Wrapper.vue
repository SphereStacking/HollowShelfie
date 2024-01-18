<script setup>
defineProps({
  id: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    required: true
  },
  modelValue: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: ''
  },
  help: {
    type: String,
    default: null
  },
  error: {
    type: String,
    default: null
  },
  type: {
    type: String,
    default: 'text'
  }
})

const emit = defineEmits(['update:modelValue'])

const updateValue = (e) => {
  // 子要素のmodelValueをe.target.valueでupdate
  emit('update:modelValue', e.target.value)
}
</script>

<template>
  <div class="flex flex-col gap-0.5">
    <div class="flex flex-row items-center justify-between gap-0.5">
      <label for="input" class="label-text font-bold">{{ label }}</label>
      <small v-if="help !== null" id="input-help" class="label-text-alt">{{ help }}</small>
    </div>
    <div class="flex flex-row">
      <slot name="left"></slot>
      <slot></slot>
      <slot name="right"></slot>
    </div>
    <InputError :message="error" />
  </div>
</template>

<style lang="">
</style>
