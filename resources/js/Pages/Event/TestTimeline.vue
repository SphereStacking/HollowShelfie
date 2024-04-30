<script setup>
import { defineProps } from 'vue'
import { format, differenceInHours, startOfDay, addHours, eachDayOfInterval, endOfDay} from 'date-fns'

const props = defineProps({
  events: {
    type: Array,
    required: true,
  },
  startDate: {
    type: Date,
    required: true,
  },
  endDate: {
    type: Date,
    required: true,
  },
})

const isDragging = ref(false)
const startX = ref(0)
const startY = ref(0)
const scrollLeft = ref(0)
const scrollTop = ref(0)

const startDragging = (event) => {
  isDragging.value = true
  startX.value = event.pageX - event.currentTarget.offsetLeft
  startY.value = event.pageY - event.currentTarget.offsetTop
  scrollLeft.value = event.currentTarget.scrollLeft
  scrollTop.value = event.currentTarget.scrollTop
}

const stopDragging = () => {
  isDragging.value = false
}

const handleMouseMove = (event) => {
  if (!isDragging.value) return
  const x = event.pageX - event.currentTarget.offsetLeft
  const y = event.pageY - event.currentTarget.offsetTop
  const walkX = (x - startX.value) * 2 // 横スクロール速度を調整
  const walkY = (y - startY.value) * 2 // 縦スクロール速度を調整
  event.currentTarget.scrollLeft = scrollLeft.value - walkX
  event.currentTarget.scrollTop = scrollTop.value - walkY
}

//-----------------------------------------------

const startDate = new Date(props.startDate)
const endDate = new Date(props.endDate)

const hoursBetween = differenceInHours(endDate, startDate) + 1 // +1 to include the end hour

const timeRanges = computed(() => {
  const days = eachDayOfInterval({ start: new Date(props.startDate), end: new Date(props.endDate) })
  return days.map((day, index, array) => {
    const date = format(day, 'yyyy-MM-dd')
    let hours
    if (index === 0) { // 最初の日
      hours = 24 - new Date(props.startDate).getHours()
    } else if (index === array.length - 1) { // 最後の日
      hours = new Date(props.endDate).getHours()
      // 終了日が開始日と同じで、かつ終了時間が開始時間よりも前の場合、24時間を基準に計算
      if (hours <= new Date(props.startDate).getHours() && days.length === 1) {
        hours = 24 - new Date(props.startDate).getHours() + new Date(props.endDate).getHours()
      }
    } else { // 中間の日
      hours = 24
    }
    return { date, hours }
  })
})

const gridColumns = computed(() => {
  return `grid-cols-${hoursBetween}`
})

const calculateGridPosition = (eventStartDate, eventEndDate) => {
  const startHour = differenceInHours(new Date(eventStartDate), startOfDay(new Date(eventStartDate)))
  const endHour = differenceInHours(new Date(eventEndDate), startOfDay(new Date(eventStartDate))) + 1 // +1 to adjust end position

  const output = { start: startHour + 1, span: endHour - startHour } // +1 since CSS grid starts at 1
  return output
}
</script>

<template>
  {{ timeRanges }}
  <div
    class="overflow-auto scrollbar-hide"
    @mousedown="startDragging"
    @mouseup="stopDragging"
    @mouseleave="stopDragging"
    @mousemove="handleMouseMove">
    <div class="sticky top-0 flex flex-row px-4">
      <div v-for="timeRange in timeRanges" :key="timeRange.date" class="z-20 flex flex-col gap-2 bg-base-100 pr-2">
        <div class="grid  gap-2">
          <div class="sticky left-0 row-start-1 w-full">
            {{ timeRange.date }}
          </div>
          <div class="row-start-2 flex flex-row gap-2">
            <div v-for="hour in timeRange.hours" :key="hour" class=" mb-2 w-36 rounded-md bg-base-200 px-4 py-2 text-center">
              {{ format(addHours(startDate, hour - 1), 'HH:mm') }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      :class="` rounded-xl grid ${gridColumns} gap-2 p-4 grid-flow-dense h-screen select-none`">
      <!--cellのサイズを固定化する-->
      <div v-for="hour in hoursBetween" :key="hour" class=" h-2 w-36">
      </div>

      <div
        v-for="(event, index) in events" :key="index" :style="{ gridColumn: `${calculateGridPosition(event.start_date, event.end_date).start} / span ${calculateGridPosition(event.start_date, event.end_date).span}` }"
        class=" rounded-md bg-base-200 p-2 text-base-content"
        @click="console.log(event)">
        <div class=" flex flex-row justify-between gap-2">
          <div class="flex flex-row gap-0.5">
            <div v-for="organizer in event.organizers" :key="organizer.id" class="flex flex-row items-center justify-center">
              <img :src="organizer.image_url" class="h-6 rounded-md">
            </div>
          </div>
          <div class="text-lg font-bold">
            {{ event.title }}
          </div>
          <div class="flex flex-row items-center justify-center gap-0.5">
            <button class="btn btn-ghost btn-xs p-0.5">
              <Icon icon="mdi:format-float-right" class="text-xl" />
            </button>
            <button class="btn btn-ghost btn-xs p-0.5">
              <IconTypeMapper type="onBookmarks" class="text-xl" />
            </button>
            <button class="btn btn-ghost btn-xs p-0.5">
              <Icon icon="mdi:dots-vertical" class="text-xl" />
            </button>
          </div>
        </div>
        <div class="mt-2 flex flex-row justify-around gap-1">
          <div v-for="item in event.time_table" :key="item.id" class=" flex w-full flex-row items-center justify-center gap-2 rounded-md bg-base-300 text-center">
            <div v-for="performer in item.performers" :key="performer.id" class="p-2">
              <img :src="performer.image_url" class="h-8 rounded-md">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
</style>
