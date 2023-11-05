// src/App.vue

<script setup>
import { ref } from 'vue';
import { eachHourOfInterval, eachDayOfInterval, startOfDay, endOfDay, format } from 'date-fns';

import GanttTimeArea from "./Gantt/TimeArea.vue";

// 期間を設定（例：2023-01-01から2023-01-03）
const startDate = new Date('2023-01-01');
const endDate = new Date('2023-01-03');

// 指定した期間内の各日にちを取得
const days = eachDayOfInterval({ start: startDate, end: endDate });

// 各日にちに対応する時間を生成
const times = days.map(day => {
  const start = startOfDay(day);
  const end = endOfDay(day);
  const hours = eachHourOfInterval({ start, end });
  const formattedHours = hours.map(hour => format(hour, 'HH:mm'));
  return {
    date: format(day, 'yyyy-MM-dd'),
    hours: formattedHours
  };
});

</script>

<template>
  <div class="flex flex-row">
    <!-- タスクを表示する領域 -->
    <div class="flex-none w-1/44 p-4 border-r">
      <h1 class="text-lg font-bold mb-4">タスク</h1>
      <ul>
        <li v-for="task in tasks" :key="task">{{ task }}</li>
      </ul>
    </div>
    <GanttTimeArea :times="times"></GanttTimeArea>
  </div>
</template>
