<script setup>
const props=defineProps({
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
  warning: { // 警告メッセージ
    type: String,
    default: null
  },
})

const modelValue= ref(props.modelValue)

</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :warning="warning"
    :label-icon-type="labelIconType">
    <DatePickerWrapper v-model="modelValue" time-picker text-input />
  </Wrapper>
</template>

<style lang="">
</style>
