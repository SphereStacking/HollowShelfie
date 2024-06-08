<script setup>
import { defineAsyncComponent, ref, computed, watchEffect } from 'vue'
import VueDatepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import { traverseObj } from '@/Sunbirds/Utility/Utils'

const TimePicker = defineAsyncComponent(() => import('./parts/TimePickerCustom.vue'))

const modelValue = ref({})
const type = ref('date')
const optins = ref({})
const date = ref(null)
const defOptions = ref({
  type: 'datetime-local',
  format: 'yyyy/MM/dd HH:mm',
  placeholder: '年/月/日 時:分',
  step: {hours: 1, minutes: 5}
})

const timePicker = computed(() => TimePicker)

watchEffect(() => {
  if (modelValue.value) {
    modifyType()
  }
})

watchEffect(() => {
  if (date.value) {
    emit('update:modelValue', date.value)
  }
})

traverseObj(optins.value, defOptions.value)

function modifyType() {
  let type = Object.prototype.toString.call(modelValue.value)
  switch (type) {
  case '[object Object]':
    date.value = modelValue.value
    break
  case '[object String]':
    date.value = new Date(modelValue.value)
    break
  case '[object Date]':
    date.value = modelValue.value
    break
  default:
    break
  }
}

</script>

<template>
  <VueDatepicker
    v-model="date"
    locale="ja"
    :format="defOptions.format"
    :placeholder="defOptions.placeholder"
    :time-picker-component="timePicker"
    :close-on-auto-apply="false"
    week-start="0"
    :minutes-grid-increment="defOptions.step.minutes"
    auto-apply
    show-now-button />
</template>

<style lang="">

</style>
