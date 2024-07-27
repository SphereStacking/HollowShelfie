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
  labelIconType: {
    type: String,
    default: ''
  },
  modelValue: {
    type: Date,
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
  warning: {
    type: String,
    default: null
  },

})

const emit = defineEmits(['update:modelValue'])
const updateModelValue = (newDate) => {
  emit('update:modelValue', newDate)
}
</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :warning="warning"
    :label-icon-type="labelIconType">
    <DatePickerWrapper
      v-bind="$attrs"
      :model-value="modelValue"
      text-input
      time-picker-inline
      format="yyyy/MM/dd HH:mm"
      @update:model-value="updateModelValue($event)" />
  </Wrapper>
</template>

<style lang="">
</style>
