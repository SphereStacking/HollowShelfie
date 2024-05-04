<script setup lang="ts">
import { format, addHours, eachDayOfInterval} from 'date-fns'
import { parseToBrowserTz } from '@/Utill/Date'

const props = defineProps({
  columnsPerHour: {
    type: Number,
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

//-----------------------------------------------

const startDate = new Date(props.startDate)
const endDate = new Date(props.endDate)
console.log('getHours props.startDate : ', props.startDate)
console.log('getHours props.endDate   : ', props.endDate)

const timeRanges = computed(() => {
  console.log('getHours start : ', startDate)
  console.log('getHours end   : ', endDate)
  const days = eachDayOfInterval({ start: startDate, end: endDate })
  return days.map((day, index, array) => {
    const date = format(day, 'M/d')
    const hours = []
    const startHour = index === 0 ? startDate.getHours() : 0
    const endHour = index === array.length - 1 ? endDate.getHours() : 23

    for (let hour = startHour; hour <= endHour; hour++) {
      hours.push(format(addHours(day, hour), 'HH:mm'))
    }
    // 最後の時間を追加するための条件
    if (index === array.length - 1 && endDate.getMinutes() > 0) {
      hours.push(format(endDate, 'HH:mm'))
    }

    return { date, hours }
  })
})

</script>

<template>
  <template v-for="timeRange in timeRanges" :key="timeRange">
    <div class="row-start-1 w-full" :style="` grid-column: span ${timeRange.hours.length * columnsPerHour} / span ${timeRange.hours.length * columnsPerHour}; `">
      <div class="sticky left-0 mr-2 inline text-nowrap text-xl">
        {{ timeRange.date }}
      </div>
    </div>
    <div v-for="hour in timeRange.hours" :key="hour" class="sticky top-auto col-span-4 row-start-2 rounded-md bg-base-300 py-1 text-center">
      {{ hour }}
    </div>
  </template>
</template>

<style>
</style>
