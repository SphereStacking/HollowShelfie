<script setup lang="ts">
import { format, addHours, eachDayOfInterval} from 'date-fns'

const props = defineProps({
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

</script>

<template>
  <template v-for="timeRange in timeRanges" :key="timeRange.date">
    <div class="row-start-1 w-full" :style="` grid-column: span ${timeRange.hours * 4} / span ${timeRange.hours * 4}; `">
      <div class="sticky left-0 mr-2 inline text-nowrap text-xl">
        {{ timeRange.date }}
      </div>
    </div>
    <div v-for="hour in timeRange.hours" :key="hour" class="sticky top-auto col-span-4 row-start-2 rounded-md bg-base-200 py-1 text-center">
      {{ format(addHours(startDate, hour - 1), 'HH:mm') }}
    </div>
  </template>
</template>

<style>
</style>
