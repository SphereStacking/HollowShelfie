<script setup lang="ts">
import { differenceInMinutes } from 'date-fns'
import { getEventPeriod } from '@/Utils/Event'
import { parseToBrowserTz } from '@/Utils/Date'
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

// eventStartDate ~eventEndDateによって
// 10分ごとに区切られたgridが存在しており
// 各eventItemStartDate ~eventItemEndDate
// startColumnとendColumnを計算する処理を作成して
const calculateGridSpan = (startDate, endDate) => {
  let eventStartDate = parseToBrowserTz(props.timeLineItem.startDate)
  let eventItemStartDate = parseToBrowserTz(startDate)
  let eventItemEndDate = parseToBrowserTz(endDate)

  // イベント全体の開始から各アイテムの開始までの分数を計算
  const startDiff = differenceInMinutes(new Date(eventItemStartDate), new Date(eventStartDate))
  // イベント全体の開始から各アイテムの終了までの分数を計算
  const endDiff = differenceInMinutes(new Date(eventItemEndDate), new Date(eventStartDate))

  // 10分ごとに1カラムなので、10で割って1を足す（1-indexed）
  const startColumn = Math.floor(startDiff / 10) + 1
  const endColumn = Math.floor(endDiff / 10) + 1

  return `grid-column: ${startColumn} / ${endColumn};`
}

const good: Good = {
  isGood: props.timeLineItem.authUser.isGood,
  goodCount: props.timeLineItem.shortGoodCount,
}
const sns: SnsShare = {
  title: props.timeLineItem.title,
  period: getEventPeriod(props.timeLineItem.startDate, props.timeLineItem.endDate),
  route: route('event.show', props.timeLineItem.alias),
  // instances: props.timeLineItem.instances.map((instance) => instance.display_name),
  // organizers: props.timeLineItem.organizers.map((organizer) => organizer.name),
  // performers: props.timeLineItem.performers.map((performer) => performer.name),
  categoryNames: props.timeLineItem.categoryNames,
  tags: props.timeLineItem.tags.map((tag) => '#'+tag),
}
const bookmark: Bookmark = {
  isBookmark: props.timeLineItem.authUser.isBookmark,
}
</script>

<template>
  <div class="rounded-md bg-base-200 p-2 text-base-content" @click="console.debug(timeLineItem)">
    <div class="flex flex-row justify-between">
      <div class="flex flex-row gap-2">
        <Link v-for="organizer in timeLineItem.organizers" :key="organizer.id" :href="organizer.profile_url">
          <img :src="organizer.image_url" class="h-6 rounded-md">
        </Link>
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
          v-if="item.performers.length > 0"
          :style="calculateGridSpan(item.start_date, item.end_date)"
          :performers="item.performers"
          @click="console.debug(item.start_date,item.end_date)" />
      </template>
    </div>
  </div>
</template>
