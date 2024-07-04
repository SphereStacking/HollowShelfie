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
  discription: {
    type: String,
    required: true
  },
  modelValue: {
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

const InputType = 'checkbox'

const emit = defineEmits(['update:modelValue'])

const updateValue = (e) => {
  // 子要素のmodelValueをe.target.valueでupdate
  emit('update:modelValue', e.target.value)
}
</script>

<template>
  <Wrapper :label="label" :help="help" :error="error">
    <label class=" flex cursor-pointer flex-row items-center gap-2">
      <input
        :type="InputType"
        :checked="modelValue"
        class="checkbox bg-transparent"
        @change="updateValue">
      <span class="label-text">{{ discription }}</span>
    </label>
  </Wrapper>
</template>

<style lang="">
</style>
