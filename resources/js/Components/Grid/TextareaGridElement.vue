<script setup>
import { useTextareaAutosize } from '@vueuse/core'

const { textarea, input } = useTextareaAutosize()
const props=defineProps({
  modelValue: {
    type: String,
    default: ''
  },
})
const emit = defineEmits(['update:modelValue'])

input.value=props.modelValue

watch(input, (newValue) => {
  console.log('hoge')
  emit('update:modelValue', newValue)
})
</script>

<template>
  <textarea
    ref="textarea"
    v-model="input" class="textarea h-full w-full resize-none overflow-hidden"></textarea>
</template>

<style lang="">
</style>
