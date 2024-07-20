<script setup lang="ts">
import { differenceInMinutes } from 'date-fns'
import { parseToBrowserTz } from '@/Utils/Date'
import type { TimeLineItem } from '../EventTimeLineTypes'
import { Good, Bookmark } from '../../EventOtherBtn/BtnDropDownOtherTypes'
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
const bookmark: Bookmark = {
  isBookmark: props.timeLineItem.authUser.isBookmark,
}

const emit = defineEmits(['share'])
</script>

<template>
  <div class="flex flex-col justify-between gap-1 rounded-xl border border-neutral bg-base-200 p-2 text-base-content" @click="console.debug(timeLineItem)">
    <div class="w-full">
      <span class="sticky left-1">
        <AvatarLink
          v-for="(organizer, index ) in timeLineItem.organizers"
          :key="index"
          class="mr-1"
          :href="organizer.profile_url"
          :data-tip="organizer.name"
          size="size-6"
          rounded="rounded-lg"
          :image-url="organizer.image_url" :name="organizer.name" />
      </span>
    </div>
    <div class="tooltip flex flex-row items-center justify-between" :data-tip="timeLineItem.title">
      <Link :href="timeLineItem.route" class="sticky left-1 truncate transition-all duration-200 hover:text-accent hover:underline ">
        {{ timeLineItem.title }}
      </Link>
    </div>
    <div
      class="grid select-none grid-flow-dense gap-1"
      :style="`grid-template-columns: repeat(${calculateTotalColumns(timeLineItem.startDate, timeLineItem.endDate)}, minmax(0, 1fr));`">
      <div
        v-for="(item, index) in timeLineItem.timeTable" :key="index"
        :style="calculateGridSpan(item.start_date, item.end_date)"
        class="tooltip rounded-lg bg-neutral p-1" :data-tip="item.description">
        <p class="truncate text-xs">
          {{ item.description }}
        </p>
      </div>
    </div>
  </div>
</template>
