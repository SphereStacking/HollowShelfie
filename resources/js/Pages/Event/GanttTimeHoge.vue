<script setup>
import dayjs from 'dayjs';
import duration from 'dayjs/plugin/duration';
import utc from 'dayjs/plugin/utc';
import timezone from 'dayjs/plugin/timezone';
dayjs.extend(duration);
dayjs.extend(utc);
dayjs.extend(timezone);

// propsを受け取る
const { events, dateSpan } = defineProps(['events', 'dateSpan']);

const currentTimeLeftMarginRem = ref()
const currentTimeColumn = ref()

// 一時間あたりのミリ秒数
const MS_PER_HOUR = 3600000;

// 一時間あたりの列数
const COLUMNS_PER_HOUR = 4;

// ミリ秒を時間に変換するユーティリティ関数
const msToHours = (ms) => ms / MS_PER_HOUR;
const logOutput = (date) => console.log(date)

const columnNum = () => {
  // 開始日時と終了日時をDateオブジェクトに変換
  const startDate = dayjs(dateSpan.start_date);
  const endDate = dayjs(dateSpan.end_date);

  // 日付と時間の差をミリ秒で計算
  const differenceInMilliseconds = endDate.diff(startDate);

  // ミリ秒を時間に変換（1時間 = 3600000ミリ秒）
  const differenceInHours = differenceInMilliseconds / MS_PER_HOUR;

  // 1時間あたり4列なので、列数を計算
  const numberOfColumns = differenceInHours * 4;
  return numberOfColumns
}

// 列位置を計算
const calculateGridColumnStart = (start_date) => {
  const startDate = dayjs(start_date);
  const baseDate = dayjs(dateSpan.start_date);
  const startCol = msToHours(startDate.diff(baseDate)) * COLUMNS_PER_HOUR; // ユーティリティ関数と定数を使用

  return startCol + 1;
};

// 列のスパンを計算
const calculateGridColumnSpan = (start_date, end_date) => {
  const startDate = dayjs(start_date);
  const endDate = dayjs(end_date);
  const differenceInMilliseconds = endDate.diff(startDate);
  const differenceInHours = msToHours(differenceInMilliseconds); // ユーティリティ関数を使用
  const numberOfColumns = differenceInHours * COLUMNS_PER_HOUR; // 定数を使用

  return numberOfColumns;
};

// 列位置とスパンを計算
const calculateGridPosition = (start_date, end_date) => {
  const startCol = calculateGridColumnStart(start_date);  // 列位置を計算
  const span = calculateGridColumnSpan(start_date, end_date);  // 列のスパンを計算

  return `${startCol} / span ${span}`
};
const formattedDates = () => {
  const startDate = dayjs(dateSpan.start_date);
  const endDate = dayjs(dateSpan.end_date);
  const allDates = [];
  let currentDate = startDate;
  while (currentDate.isBefore(endDate) || currentDate.isSame(endDate)) {
    allDates.push(currentDate.format('YYYY-MM-DD'));
    currentDate = currentDate.add(1, 'day');
  }
  return allDates;
}
const calculateCurrentTimeColumn = (now) => {
  const baseDate = dayjs(dateSpan.start_date);
  const startCol = msToHours(now.diff(baseDate)) * COLUMNS_PER_HOUR;
  return Math.floor(startCol) + 1;
};

const calculateMarginInRem = (now) => {
  // 現在の分と秒を取得
  const minutes = now.minute();
  const seconds = now.second();

  // 1時間（col-span-4）あたりのrem値
  const remPerHour = 2 * 4; // 8rem

  // 分と秒を元にオフセット（余分なrem値）を計算
  const offsetRem = (minutes * remPerHour / 60) + (seconds * remPerHour / 3600);

  return offsetRem;
}

const updateTickBar = () => {
  const now = dayjs();
  currentTimeLeftMarginRem.value = calculateMarginInRem(now)
  currentTimeColumn.value = calculateCurrentTimeColumn(now);
}

// eventsが変更されたときやdateSpanが変更されたときに再計算する
watch([events, dateSpan], () => {
  updateTickBar();
});

// 1秒ごとに現在時刻のバーを更新する
setInterval(() => {
  updateTickBar();
}, 1000);
</script>
<template>
  <div class="overflow-hidden flex flex-col overflow-x-auto">
    <div class="flex flex-row">
      <div class="grid grid-rows-2  gap-0.5"
        :style="`grid-template-columns: repeat(${columnNum()}, minmax(2.0rem, 1fr))`">

        <template v-for="time in  formattedDates() ">
          <!-- Horizontal lines -->
          <div class="text-left row-start-1 " style="grid-column:  span 96">
            <!-- 日にちを表示 -->
            <h2 class="sticky text-xl font-semibold ">{{ time }}</h2>
          </div>
          <div class="row-start-2 grid col-span-4" v-for="(hour, index) in 24">
            <div class="left-0 w-full  leading-5 badge  badge-ghost ">{{ index }}:00</div>
          </div>
        </template>
      </div>
    </div>
    <div class="relative grid grid-rows-2 gap-0.5"
      :style="`grid-template-columns: repeat(${columnNum()}, minmax(2.0rem, 1fr))`">

      <!-- 現在時刻のバーを追加 -->
      <div :style="{
        zIndex: 10,
        gridColumn: currentTimeColumn,
        marginLeft: `${currentTimeLeftMarginRem}rem`,
      }" class="absolute bg-red-500  h-full w-1 ml-2">
      </div>
      <template v-for="( task, index ) in  events ">
        <div class="flex flex-col row-span-2" :style="{
          gridColumn: calculateGridPosition(task.start_date, task.end_date)
        }
          ">
          <div class="bg-primary w-full rounded-xl text-center border text-primary-content" @click="logOutput(task)">
            {{ task.title }}
            <div class="flex flex-row justify-around mb-1 mx-0.5">
              <div v-for="( item, timetableIndex ) in  task.timetable " class="badge badge-ghost w-full mx-0.5">
                {{ item.title }}
              </div>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>
