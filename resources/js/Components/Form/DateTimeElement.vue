<script setup>
import { format, startOfDay, addMinutes, set, differenceInMinutes } from 'date-fns'
import Slider from '@vueform/slider'

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
const slideValue = ref([540, 2280])
const step = ref(15)
const sliderMax = ref(2880)
const tooltipMerge = ref(900)
const dates = ref([
  startOfDay(new Date()),
  startOfDay(new Date())
])

// const emit = defineEmits(['update:modelValue'])
// const updateValue = (e) => {
//   // 子要素のmodelValueをe.target.valueでupdate
//   emit('update:modelValue', e.target.value)
// }

/* calendarの設定 */
const textInputOptions = {
  format: ['yyyy/MM/dd HH:mm', 'HH:mm']
}
const formatDate = (date) => {
  if (dates.value.length != 2) {
    return ''
  }
  const start = date[0]
  const end = date[1]
  if (!(start instanceof Date) || isNaN(start.getTime()) || !(end instanceof Date) || isNaN(end.getTime())) {
    return ''
  }
  return `${format(start, 'yyyy/MM/dd HH:mm')} - ${format(end, 'HH:mm')}`
}

/* スライダー */
const SliderTooltip = (value) => {
  const hours = Math.floor(value / 60).toString().padStart(2, '0')
  const minutes = Math.floor(value % 60).toString().padStart(2, '0')
  return `${hours} : ${minutes}`
}

/* calendarのside contents */
const incrementMonth = (selectDate) => {
  dates.value = dates.value.map(d => {
    const newDate = new Date(d)
    newDate.setMonth(newDate.getMonth() + 1)
    return newDate
  })
  selectDate({ value: dates.value[0], current: true })
}
const decrementMonth = (selectDate) => {
  dates.value = dates.value.map(d => {
    const newDate = new Date(d)
    newDate.setMonth(newDate.getMonth() - 1)
    return newDate
  })
  selectDate({ value: dates.value[0], current: true })
}
const setTimeRange = (startHour, endHour) => {
  const startDate = set(new Date(), { hours: startHour, minutes: 0 })
  const endDate = set(new Date(), { hours: endHour, minutes: 0 })
  const start = differenceInMinutes(startDate, startOfDay(startDate))
  const end = differenceInMinutes(endDate, startOfDay(startDate))
  slideValue.value = [start, end]
}
const updateStep = (e) => {
  step.value = Number(e.target.value)
}

const shiftSlide = (index, direction) => {
  const newValue = slideValue.value[index] + step.value * direction
  // スライダーの最小値と最大値を超えないように制限をかける
  slideValue.value[index] = Math.max(0, Math.min(newValue, sliderMax.value))
}

</script>

<template>
  <Wrapper :label="label" :help="help" :error="error">
    <DatePickerWrapper
      v-model="dates"
      locale="ja"
      :format="formatDate"
      :text-input="textInputOptions"
      range
      auto-range="0"
      over
      dark
      @internal-model-change="handleInternal">
      <template #left-sidebar="{selectDate}">
        <div class="flex h-full flex-col justify-end gap-1 pb-2">
          <div class="h-5">
            Date
          </div>
          <button class="btn btn-primary btn-xs w-28 rounded-sm" @click="selectDate({ value: new Date(), current: true })">
            To day
          </button>
          <div class="h-5">
            Month
          </div>
          <button class="btn btn-primary btn-xs w-28 rounded-sm" @click="incrementMonth(selectDate)">
            Next
          </button>
          <button class="btn btn-primary btn-xs w-28 rounded-sm" @click="decrementMonth(selectDate)">
            Previous
          </button>

          <div class="h-5">
            Time
          </div>
          <button class="btn btn-primary btn-xs w-28 rounded-sm" @click="setTimeRange(9, 38)">
            init
          </button>
          <button class="btn btn-primary btn-xs w-28 rounded-sm" @click="setTimeRange(8, 18)">
            08:00 - 18:00
          </button>
          <button class="btn btn-primary btn-xs w-28 rounded-sm" @click="setTimeRange(21, 24)">
            21:00 - 24:00
          </button>

          <div class="h-5">
            Time step
          </div>
          <select v-model="step" class="select select-xs w-full  rounded-sm py-0" @change="updateStep">
            <option :value="1">
              1
            </option>
            <option :value="5">
              5
            </option>
            <option :value="15">
              15
            </option>
            <option :value="60">
              60
            </option>
            <option :value="120">
              120
            </option>
          </select>
        </div>
      </template>
      <template #time-picker="{ time, updateTime }">
        <div class="mx-10 mb-2 mt-10">
          <Slider
            v-model="slideValue"
            :max="sliderMax"
            :format="SliderTooltip"
            :merge="tooltipMerge"
            :step="step" />
          <div class=" mt-2 grid grid-cols-5 gap-1">
            <button class="btn btn-primary btn-xs rounded-sm" @click="shiftSlide(0, -1)">
              <Icon icon="mdi:chevron-left" class="text-xl" />
            </button>
            <button class="btn btn-primary btn-xs rounded-sm" @click="shiftSlide(0, 1)">
              <Icon icon="mdi:chevron-right" class="text-xl" />
            </button>

            <div></div>

            <button class="btn btn-primary btn-xs  rounded-sm" @click="shiftSlide(1, -1)">
              <Icon icon="mdi:chevron-left" class="text-xl" />
            </button>
            <button class="btn btn-primary btn-xs   rounded-sm" @click="shiftSlide(1, 1)">
              <Icon icon="mdi:chevron-right" class="text-xl" />
            </button>
          </div>
        </div>
      </template>
    </DatePickerWrapper>
  </Wrapper>
</template>

<style src="@vueform/slider/themes/default.css"></style>

