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

})

const InputType = 'text'

const emit = defineEmits(['update:modelValue'])

const updateValue = (e) => {
  // 子要素のmodelValueをe.target.valueでupdate
  emit('update:modelValue', e.target.value)
}
</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :label-icon-type="labelIconType">
    <InputFormBase
      :id="id"
      :type="InputType"
      :placeholder="placeholder"
      class="grow"
      :class="{ 'input-error': error }"
      :value="modelValue"
      aria-describedby="input-help"
      @input="updateValue" />
  </Wrapper>
</template>

<style lang="">
</style>
