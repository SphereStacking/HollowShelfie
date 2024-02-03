<script setup>
const props=defineProps({
  modelValue: {
    type: String,
    default: ''
  },

})

const modelValue= ref(props.modelValue)
</script>

<template>
  <DatePickerWrapper
    v-model="modelValue" class=""
    time-picker text-input
    range />
</template>

<style lang="">
</style>
