<script setup>
import { format } from 'date-fns'
const props=defineProps({
  modelValue: {
    type: Array,
    default: () => [],
  },

})

const emits = defineEmits(['update:modelValue'])
const timeSpan = ref([])

watch(() => props.modelValue, (newValue) => {
  // newValueがnullまたはundefinedの場合、空の配列を使用する
  if (newValue === null || newValue === undefined || newValue === '') {
    timeSpan.value = []
  } else {
    // 有効な文字列のみを処理する
    timeSpan.value = newValue.filter(timeString => timeString && timeString.trim() !== '').map(timeString => {
      const [hours, minutes, seconds] = timeString.split(':').map(Number)
      return { hours, minutes, seconds }
    })
  }
}, { deep: true, immediate: true })

const update = (newValue) => {
  const formattedTimeSpan = newValue.map(time => {
    const date = new Date()
    date.setHours(time.hours, time.minutes, time.seconds)
    return format(date, 'HH:mm:ss')
  })
  emits('update:modelValue', formattedTimeSpan)
}

</script>

<template>
  <DatePickerWrapper
    :model-value="timeSpan"
    time-picker
    disable-time-range-validation
    text-input
    range
    @update:model-value="update" />
</template>

<style lang="">
</style>
