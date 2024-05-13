<script setup>
import { addDays, startOfWeek, startOfMonth, startOfDay, endOfDay, endOfWeek, endOfMonth, setSeconds, setMinutes } from 'date-fns'

const props = defineProps({
  items: {
    type: Array,
    required: true
  },
  addConditionFunc: {
    type: Function,
    required: true
  },
})
const isVisible = ref(false)

onMounted(() => {
  isVisible.value = true
})

onBeforeUnmount(() => {
  isVisible.value = false
})

const startDate = ref(null)
const startTime = ref(null)
const endDate = ref(null)
const endTime = ref(null)

const setToday = () => {
  startDate.value = startOfDay(new Date())
  const endToday = endOfDay(new Date())
  endDate.value = setSeconds(setMinutes(endToday, 59), 0)
  addCondition()
}

const setTomorrow = () => {
  const tomorrow = addDays(new Date(), 1)
  startDate.value = startOfDay(tomorrow)
  const endTomorrow = endOfDay(tomorrow)
  endDate.value = setSeconds(setMinutes(endTomorrow, 59), 0)
  addCondition()
}

const setThisWeek = () => {
  const now = new Date()
  startDate.value = startOfWeek(now, { weekStartsOn: 1 })
  const endThisWeek = endOfWeek(now, { weekStartsOn: 1 })
  endDate.value = setSeconds(setMinutes(endThisWeek, 59), 0)
  addCondition()
}

const setThisMonth = () => {
  const now = new Date()
  startDate.value = startOfMonth(now)
  const endThisMonth = endOfMonth(now)
  endDate.value = setSeconds(setMinutes(endThisMonth, 59), 0)
  addCondition()
}

const addCondition = () => {
  if (!startDate.value && !endDate.value) {
    alert('日時を選択してください')
    return
  }
  props.addConditionFunc({ type: 'date', value: { start: startDate.value, end: endDate.value } })
}
</script>

<template>
  <Transition
    name="slide-up"
    tag="div"
    enter-active-class="transition-all duration-200"
    enter-from-class="opacity-0 translate-y-2"
    enter-to-class="opacity-100"
    leave-active-class=""
    leave-from-class="opacity-100"
    leave-to-class="opacity-0 translate-y-2">
    <div
      v-if="isVisible"
      class="flex flex-wrap gap-2">
      <div class="flex w-full flex-col items-center gap-2 md:flex-row">
        <DatePickerWrapper
          v-model="startDate"
          placeholder="yyyy/MM/dd HH:mm"
          :text-input="{ format: 'yyyy/MM/dd HH:mm'}"
          format="yyyy/MM/dd HH:mm"
          time-picker-inline
          class="input-bordered  w-full " />
        ~
        <DatePickerWrapper
          v-model="endDate"
          placeholder="yyyy/MM/dd HH:mm"
          :text-input="{ format: 'yyyy/MM/dd HH:mm'}"
          format="yyyy/MM/dd HH:mm"
          time-picker-inline
          class="input-bordered  w-full " />
        <button class="btn btn-outline btn-sm " @click="addCondition">
          ADD
        </button>
      </div>

      <div class="divider divider-start my-0 w-full">
        <div class="flex flex-row items-center gap-1">
          <IconTypeMapper type="date" class="text-xl" />
          Quick Select
        </div>
      </div>
      <button class="btn btn-outline btn-xs" @click="setToday">
        今日
      </button>
      <button class="btn btn-outline btn-xs" @click="setTomorrow">
        明日
      </button>
      <button class="btn btn-outline btn-xs" @click="setThisWeek">
        今週
      </button>
      <button class="btn btn-outline btn-xs " @click="setThisMonth">
        今月
      </button>
    </div>
  </Transition>
</template>
<style lang="">

</style>
