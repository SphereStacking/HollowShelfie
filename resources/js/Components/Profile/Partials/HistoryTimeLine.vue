<script setup>
const timelineItems = [
  {
    description: '出演 DJ [Concert in Tokyo]',
    time: '1 days ago'
  },
  {
    description: '出演 VL [Concert in Tokyo]',
    time: '2 days ago'
  },
  {
    description: '主催 LJ [Charity Event]',
    time: '3 days ago'
  },
  {
    description: '出演 DJ [Music Workshop]',
    time: '15 days ago'
  },
  {
    description: '運営 雑用 [Art Exhibition]',
    time: '57 days ago'
  },
]
</script>
<template>
  <Card class="">
    <h4 class="text-xl text-gray-900 font-bold">Activity log</h4>
    <div class="relative px-4">
      <div class="absolute h-full border border-dashed border-opacity-20 border-secondary"></div>
      <!-- v-forを使用して各タイムラインアイテムをレンダリング -->
      <div class="flex items-center w-full my-6 -ml-1.5" v-for="(item, index) in timelineItems" :key="index">
        <div class="w-1/12 z-10">
          <div class="w-3.5 h-3.5 bg-blue-600 rounded-full"></div>
        </div>
        <div class="w-11/12">
          <p class="text-sm" v-html="item.description"></p>
          <p class="text-xs text-gray-500">{{ item.time }}</p>
        </div>
      </div>
    </div>
  </Card>
</template>


