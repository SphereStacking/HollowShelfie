<script setup lang="ts">
import { differenceInMinutes } from 'date-fns'
import type { TimeLineItem } from '../EventTimeLineTypes'
import { Good, SnsShare, Bookmark } from '../../EventOtherBtn/BtnDropDownOtherTypes'
import { Link } from '@inertiajs/vue3'

type Props = {
  timeLineItem: TimeLineItem
}

const props = defineProps<Props>()

const calculateTotalColumns = (startDate, endDate) => {
  const start = new Date(startDate)
  const end = new Date(endDate)
  const durationInMinutes = (end - start) / 60000 // ミリ秒を分に変換
  return Math.ceil(durationInMinutes / 10) // 10分ごとに1カラム
}
const calculateGridSpan = (startTime, endTime) => {
  const startDate = new Date(props.timeLineItem.startDate)
  let startDateTime = new Date(`${startDate.toISOString().split('T')[0]}T${startTime}:00`)
  let endDateTime = new Date(`${startDate.toISOString().split('T')[0]}T${endTime}:00`)

  // endTimeがstartTimeより小さい場合、翌日にまたがると見なして日付を1日進める
  if (endDateTime <= startDateTime) {
    endDateTime.setDate(endDateTime.getDate() + 1)
  }

  // イベントの開始時間がstartTimeやendTimeよりも後の場合、イベントの開始日を1日戻す
  if (startDate > startDateTime) {
    startDate.setDate(startDate.getDate() - 1)
  }

  console.log('Converted Dates - Start:', startDateTime, 'End:', endDateTime, 'Event Start:', startDate)

  if (isNaN(startDateTime.getTime()) || isNaN(endDateTime.getTime())) {
    console.error('Invalid date detected')
    return 'grid-column: 1 / 1;' // Fallback to default column span
  }

  const startColumn = Math.ceil(differenceInMinutes(startDateTime, startDate) / 10)
  const endColumn = Math.ceil(differenceInMinutes(endDateTime, startDate) / 10)
  console.log('Calculated Columns - Start:', startColumn, 'End:', endColumn)

  return `grid-column: ${startColumn} / ${endColumn};`
}

const good: Good = {
  isGood: props.timeLineItem.authUser.isGood,
  goodCount: props.timeLineItem.shortGoodCount,
}
const sns: SnsShare = {
  title: props.timeLineItem.title,
  period: props.timeLineItem.period,
  instances: props.timeLineItem.instances,
  // organizers: props.timeLineItem.organizers,
  // performers: props.timeLineItem.performers,
  organizers: [],
  performers: [],
  categoryNames: props.timeLineItem.categoryNames,
  tags: props.timeLineItem.tags,
  route: props.timeLineItem.route,
}
const bookmark: Bookmark = {
  isBookmark: props.timeLineItem.authUser.isBookmark,
}
</script>

<template>
  <div class="rounded-md bg-base-200 p-2 text-base-content" @click="console.log(timeLineItem)">
    <div class="flex flex-row justify-between">
      <div class="flex flex-row gap-2">
        <div v-for="organizer in timeLineItem.organizers" :key="organizer.id">
          <img :src="organizer.image_url" class="h-6 rounded-md">
        </div>
      </div>
      <Link :href="timeLineItem.route" class="transition-all duration-200 hover:text-accent hover:underline ">
        {{ timeLineItem.title }}
      </Link>
      <div>
        <BtnDropDownOther
          :event-alias="timeLineItem.alias" :good="good" :sns-share="sns"
          :bookmark="bookmark" />
      </div>
    </div>
    <div
      class="grid select-none grid-flow-dense gap-1"
      :style="`grid-template-columns: repeat(${calculateTotalColumns(timeLineItem.startDate, timeLineItem.endDate)}, minmax(0, 1fr));`">
      <template v-for="item in timeLineItem.timeTable" :key="item.id">
        <TimeLineItemPerformers
          :style="calculateGridSpan(item.start_time, item.end_time)"
          :performers="item.performers"
          @click="console.log(item.start_time,item.end_time)" />
      </template>
    </div>
  </div>
</template>
