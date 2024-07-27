<script setup>
import { format, addHours, eachDayOfInterval, setMinutes } from 'date-fns'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  events: {
    type: Array,
    required: true,
  },
  startDate: {
    type: String,
    required: true,
  },
  endDate: {
    type: String,
    required: true,
  },
})

const defaultSetting = {
  columnWidthRem: 2.5,
  zoom: 1,
  isScrolltoX: true,
}
const columnWidthRem = ref(defaultSetting.columnWidthRem)
const zoom = ref(defaultSetting.zoom)
const isScrolltoX = ref(defaultSetting.isScrolltoX)

const settingReset = () => {
  columnWidthRem.value = defaultSetting.columnWidthRem
  zoom.value = defaultSetting.zoom
  isScrolltoX.value = defaultSetting.isScrolltoX
}

function scrollTo(date, hour = '00:00') {
  const element = document.getElementById(`date-${date}-${hour}`) || document.getElementById(`date-${date}`)
  if (!element) return

  const container = element.closest('.overflow-x-auto')
  if (!container) return

  const scrollPosition = Math.max(0, element.offsetLeft - 20)

  container.scrollTo({
    left: scrollPosition,
    behavior: 'smooth'
  })
}

const startDate = new Date(props.startDate)
const endDate = new Date(props.endDate)

const timeRanges = computed(() => {
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

function handleWheel(event) {
  if (!isScrolltoX.value || event.deltaY === 0) return
  event.preventDefault()
  event.currentTarget.scrollLeft += event.deltaY
}

const isDragging = ref(false)
const startX = ref(0)
const startY = ref(0)
const scrollLeft = ref(0)
const scrollTop = ref(0)
/**
 * ドラッグ開始時の処理
 */
const startDragging = (event) => {
  isDragging.value = true
  startX.value = event.pageX - event.currentTarget.offsetLeft
  startY.value = event.pageY - event.currentTarget.offsetTop
  scrollLeft.value = event.currentTarget.scrollLeft
  scrollTop.value = event.currentTarget.scrollTop
}

/**
 * ドラッグ終了時の処理
 */
const stopDragging = () => {
  isDragging.value = false
}

/**
 * マウス移動時の処理
 */
const handleMouseMove = (event) => {
  if (!isDragging.value) return
  const x = event.pageX - event.currentTarget.offsetLeft
  const y = event.pageY - event.currentTarget.offsetTop
  const walkX = (x - startX.value) * 2 // 横スクロール速度を調整
  const walkY = (y - startY.value) * 2 // 縦スクロール速度を調整
  event.currentTarget.scrollLeft = scrollLeft.value - walkX
  event.currentTarget.scrollTop = scrollTop.value - walkY
}

const dates = ref([])
onMounted(() => {
  const startDate = new Date()
  const endDate = new Date(new Date().setDate(startDate.getDate() + 7))
  dates.value = [startDate, endDate]
})

const handleDate = (newValue) => {
  console.log(newValue)
  router.visit(
    route('event.timeline.index', {
      start_date: newValue[0],
      end_date: newValue[1]
    }),
  )
}

const scrollToToday = () => {
  const now = new Date()
  const roundedNow = setMinutes(now, 0) // 分を00に設定
  const formattedDate = format(roundedNow, 'M/d')
  const formattedTime = format(roundedNow, 'HH:mm')
  scrollTo(formattedDate, formattedTime)
}
</script>
<template>
  <AppLayout title="Event TimeLine" main-class="px-2 mt-10">
    <template #fixedHeader>
      <div class="flex flex-row items-center justify-between ">
        <h2 class="text-xl font-semibold leading-tight">
          Event TimeLine
        </h2>
        <div class="mb-1 flex flex-col items-start justify-end gap-1 bg-base-200 md:flex-row md:items-center">
          <div class="join">
            <div class="dropdown dropdown-end">
              <div tabindex="0" class="flex items-center justify-center">
                <button
                  class="btn btn-outline join-item btn-active btn-xs">
                  <IconTypeMapper type="calendar" class="text-xl" />
                </button>
              </div>

              <ul tabindex="0" class="menu dropdown-content" :class="[width]">
                <DatePickerInlineWrapper
                  :enable-time-picker="false"
                  :model-value="dates" placeholder="yyyy/MM/dd HH:mm"
                  :text-input="{ format: 'yyyy/MM/dd HH:mm'}"
                  format="yyyy/MM/dd HH:mm"
                  :range="{ autoRange: 7 }" @update:model-value="handleDate" />
              </ul>
            </div>
            <button
              v-for="timeRange in timeRanges"
              :key="timeRange.date"
              class="btn btn-outline join-item btn-xs"
              @click="scrollTo(timeRange.date)">
              {{ timeRange.date }}
            </button>
          </div>
          <BtnDropdown class="dropdown-end" width="w-52">
            <template #trigger>
              <button class="btn btn-ghost btn-xs tooltip tooltip-left p-0" data-tip="Timeline Setting">
                <IconTypeMapper type="setting" class="text-xl" />
              </button>
            </template>
            <BtnDropdownItem>
              <div class="flex w-full flex-col">
                <label class="mb-0.5 block text-xs font-medium">
                  Zoom
                </label>
                <input
                  v-model.number="zoom" type="range" min="0.5"
                  max="1.5"
                  class="range range-xs" step="0.1">
              </div>
            </BtnDropdownItem>
            <BtnDropdownItem>
              <div class="flex w-full flex-col">
                <label class="mb-0.5 block text-xs font-medium">
                  1時間の幅
                </label>
                <input
                  v-model.number="columnWidthRem" type="range" min="1"
                  max="4"
                  class="range range-xs" step="0.5">
              </div>
            </BtnDropdownItem>
            <BtnDropdownItem>
              <label class=" flex cursor-pointer flex-row items-center justify-center gap-2">
                <input
                  id="confirm"
                  v-model="isScrolltoX" type="checkbox" checked="checked"
                  class="checkbox checkbox-xs bg-transparent">
                <span class="label-text text-xs">🖲スクロール方向</span>
              </label>
            </BtnDropdownItem>

            <BtnDropdownItem>
              <button class="btn btn-ghost btn-xs" @click="scrollToToday">
                <IconTypeMapper type="timelineToCurrentTime" class="text-xl" />
                現在時刻
              </button>
            </BtnDropdownItem>
            <BtnDropdownItem>
              <button class="btn btn-ghost btn-xs" @click="settingReset">
                <IconTypeMapper type="reset" class="text-xl" />
                リセット
              </button>
            </BtnDropdownItem>
          </BtnDropDown>
        </div>
      </div>
    </template>

    <div
      class=" mt-1 h-[calc(100vh-15rem)] overflow-x-auto rounded-lg bg-base-300/10 scrollbar-hide"
      @wheel="handleWheel"
      @mousedown="startDragging"
      @mouseup="stopDragging"
      @mouseleave="stopDragging"
      @mousemove="handleMouseMove">
      <EventTimeline
        :events="events" :start-date="startDate" :end-date="endDate"
        :column-width-rem="columnWidthRem"
        :style="{ transform: `scale(${zoom})`, transformOrigin: 'top center' }" />
    </div>
  </AppLayout>
</template>
<style>
</style>
