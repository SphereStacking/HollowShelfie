<script setup>
import { format, startOfDay, set, differenceInMinutes } from 'date-fns'
import Slider from '@vueform/slider'

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
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
    default: 'yyyy/MM/dd HH:mm - yyyy/MM/dd HH:mm'
  },
  help: {
    type: String,
    default: null
  },
  error: {
    type: String,
    default: null
  },
  warning: { // 警告メッセージ
    type: String,
    default: null
  },
})
// ステップのオプションを定義
const stepOptions = [1, 5, 15, 60, 120]

// 時間範囲を設定するためのヘルパーメソッド
const timeRanges = [
  { label: '08:00 - 18:00', start: 8, end: 18 },
  { label: '21:00 - 24:00', start: 21, end: 24 }
]

const slideValue = ref([540, 2280])
const step = ref(15)
const sliderMax = ref(2879)
const tooltipMerge = ref(900)

// modelValueの検証関数
const isValidModelValue = (value) => {
  return Array.isArray(value) && value.length === 2 && value.every(date => date instanceof Date)
}

// modelValueが適切な形式であればそれを使用し、そうでなければデフォルトの値を使用します。
const dates = ref(isValidModelValue(props.modelValue) ? props.modelValue : [])

/* calendarの設定 */
const textInputOptions = {
  format: ['yyyy/MM/dd HH:mm', 'yyyy/MM/dd HH:mm']
}

const formatDate = (date) => {
  if (!Array.isArray(date) || date.length !== 2) {
    return ''
  }
  return `${format(date[0], 'yyyy/MM/dd HH:mm')} - ${format(date[1], 'yyyy/MM/dd HH:mm')}`
}
/* スライダー */
const SliderTooltip = (value) => {
  const hours = Math.floor(value / 60).toString().padStart(2, '0')
  const minutes = Math.floor(value % 60).toString().padStart(2, '0')
  return `${hours} : ${minutes}`
}

const adjustSlideValue = (index, direction) => {
  const newValue = slideValue.value[index] + step.value * direction
  // スライダーの最小値と最大値を超えないように制限をかける
  slideValue.value[index] = Math.max(0, Math.min(newValue, sliderMax.value))
}

/* calendarのside contents */
const changeMonth = (increment, selectDate) => {
  dates.value = dates.value.map(d => {
    const newDate = new Date(d)
    newDate.setMonth(newDate.getMonth() + (increment ? 1 : -1))
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

//watch

watch(slideValue, (newValue) => {
  dates.value = newValue.map(time => {
    const hours = Math.floor(time / 60)
    const minutes = time % 60
    return set(new Date(), { hours, minutes })
  })
})

watch(dates, (newDates) => {
  if (!isValidModelValue(newDates)) { return }
  emit('update:modelValue', newDates)
})
</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :warning="warning">
    <DatePickerWrapper
      v-model="dates"
      :format="formatDate"
      :text-input="textInputOptions"
      :placeholder="placeholder"
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
          <button class="btn btn-primary btn-xs w-28 rounded-sm" @click="changeMonth(1,selectDate)">
            Next
          </button>
          <button class="btn btn-primary btn-xs w-28 rounded-sm" @click="changeMonth(-1,selectDate)">
            Previous
          </button>

          <div class="h-5">
            Time
          </div>
          <button
            v-for="time in timeRanges" :key="time.label" class="btn btn-primary btn-xs w-28 rounded-sm"
            @click="setTimeRange(time.start, time.end)">
            {{ time.label }}
          </button>

          <div class="h-5">
            Time step
          </div>
          <select v-model="step" class="select select-xs w-full  rounded-sm py-0" @change="updateStep">
            <option v-for="option in stepOptions" :key="option" :value="option">
              {{ option }}
            </option>
          </select>
        </div>
      </template>
      <template #time-picker>
        <div class="mx-10 mb-2 mt-10">
          <Slider
            v-model="slideValue"
            :max="sliderMax"
            :format="SliderTooltip"
            :merge="tooltipMerge"
            :step="step" />
          <div class=" mt-2 grid grid-cols-5 gap-1">
            <button class="btn btn-primary btn-xs rounded-sm" @click="adjustSlideValue(0, -1)">
              <IconTypeMapper type="arrowLeft" class="text-xl" />
            </button>
            <button class="btn btn-primary btn-xs rounded-sm" @click="adjustSlideValue(0, 1)">
              <IconTypeMapper type="arrowRight" class="text-xl" />
            </button>

            <div></div>

            <button class="btn btn-primary btn-xs  rounded-sm" @click="adjustSlideValue(1, -1)">
              <IconTypeMapper type="arrowLeft" class="text-xl" />
            </button>
            <button class="btn btn-primary btn-xs   rounded-sm" @click="adjustSlideValue(1, 1)">
              <IconTypeMapper type="arrowRight" class="text-xl" />
            </button>
          </div>
        </div>
      </template>
    </DatePickerWrapper>
  </Wrapper>
</template>

<style src="@vueform/slider/themes/default.css"></style>

