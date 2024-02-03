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

})

const modelValue= ref(props.modelValue)

</script>

<template>
  <input v-model="modelValue" class="input  h-full w-full">
</template>

<style lang="">
</style>
