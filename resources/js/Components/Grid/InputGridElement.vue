<script setup>
const props=defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  templateOptions: {
    type: Object,
    default: ()=>{},
  }
})

const modelValue= ref(props.modelValue)

const emit = defineEmits(['update:modelValue'])

watch(modelValue, ()=>{
  emit('update:modelValue', modelValue.value)
})
</script>

<template>
  <input
    v-model="modelValue"
    v-bind="templateOptions"
    class=" input input-bordered h-full w-full">
</template>

<style lang="">
</style>
