<script setup>

const dateSpan = {
  start_date: '2023-10-31T00:00',
  end_date: '2023-11-02T00:00'
}

const events = [
  {
    title: 'ほげ', start_date: '2023-10-31T00:30', end_date: '2023-10-31T02:00',
    timetable: [
      { title: '一郎', start_date: '2023-10-31T00:30', end_date: '2023-10-31T01:00' },
      { title: '次郎', start_date: '2023-10-31T01:00', end_date: '2023-10-31T02:00' },
    ]
  },
  {
    title: 'ふが', start_date: '2023-10-31T01:45', end_date: '2023-10-31T05:00',
    timetable: [
      { title: '三郎', start_date: '2023-10-31T01:45', end_date: '2023-10-31T03:00' },
      { title: '四郎', start_date: '2023-10-31T03:00', end_date: '2023-10-31T04:00' },
      { title: '五郎', start_date: '2023-10-31T04:00', end_date: '2023-10-31T05:00' },
    ]
  },
  {
    title: 'ぴよ', start_date: '2023-10-31T03:00', end_date: '2023-10-31T05:00',
    timetable: [
      { title: '6汰', start_date: '2023-10-31T01:45', end_date: '2023-10-31T03:00' },
      { title: 'セブン', start_date: '2023-10-31T03:00', end_date: '2023-10-31T04:00' },
      { title: 'えいた', start_date: '2023-10-31T04:00', end_date: '2023-10-31T05:00' },
    ]
  },
  {
    title: 'ぷよ', start_date: '2023-10-31T04:00', end_date: '2023-10-31T10:00',
    timetable: [
      { title: '九十九', start_date: '2023-10-31T01:45', end_date: '2023-10-31T03:00' },
      { title: 'とーま', start_date: '2023-10-31T03:00', end_date: '2023-10-31T04:00' },
    ]
  },
  { title: 'ぺよ', start_date: '2023-10-31T07:30', end_date: '2023-10-31T21:30', timetable: [] },
  { title: 'ぱよ', start_date: '2023-10-31T07:30', end_date: '2023-11-01T07:30', timetable: [] },
  { title: 'ぷよ', start_date: '2023-11-02T07:30', end_date: '2023-11-02T07:30', timetable: [] },
]
</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-neutral ">
        イベントタイムライン
      </h2>
    </template>
    <div class="max-w-7xl mx-auto pt-4">
      <div class="flex flex-row gap-2 items-center">
        <SelectMulti></SelectMulti>
        <BtnInfo @click="search">search</BtnInfo>
      </div>
      <GanttTimeHoge :dateSpan="dateSpan" :events="events"></GanttTimeHoge>
    </div>

  </AppLayout>
</template>
<style >
</style>
