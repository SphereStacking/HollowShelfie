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
    default: 'hoge'
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

defineEmits(['update:modelValue'])

</script>

<template>
  <Wrapper :label="label" :help="help" :error="error">
    <textarea
      :id="id"
      class="textarea textarea-bordered w-full rounded-md" :placeholder="placeholder"
      :value="modelValue" aria-describedby="input-help"
      @input="$emit('update:modelValue', $event.target.value)"></textarea>
  </Wrapper>
</template>

<style lang="">
</style>
