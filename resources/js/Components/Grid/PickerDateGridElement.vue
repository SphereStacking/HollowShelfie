<script setup>
import { format } from 'date-fns'
const props=defineProps({
  modelValue: {
    type: Array,
    default: () => [],
  },

})

const emits = defineEmits(['update:modelValue'])
const date = ref([])

watch(() => props.modelValue, (newValue) => {
  date.value =newValue
}, { deep: true, immediate: true })

const update = (newValue) => {
  date.value = newValue
  emits('update:modelValue', date.value)
}
</script>

<template>
  <DatePickerWrapper
    class="input-bordered"
    :model-value="date"
    disable-time-range-validation
    text-input
    :teleport="true"
    time-picker-inline
    format="yyyy/MM/dd HH:mm"
    @update:model-value="update" />
</template>

<style lang="">
</style>
