<script setup>
const props = defineProps({
  histories: {
    type: String,
    required: true
  },
})
</script>
<template>
  <Card class="">
    <h4 class="text-xl font-bold text-gray-900">
      Activity log
    </h4>
    <div class="relative px-4">
      <div class="absolute h-full border border-dashed border-secondary border-opacity-20"></div>
      <!-- v-forを使用して各タイムラインアイテムをレンダリング -->
      <div v-for="(item, index) in histories" :key="index" class="my-6 -ml-1.5 flex w-full items-center">
        <div class="z-10 w-1/12">
          <div class="h-3.5 w-3.5 rounded-full bg-blue-600"></div>
        </div>
        <div class="w-11/12">
          <p class="text-sm" v-html="item.description"></p>
          <p class="text-xs text-gray-500">
            {{ item.time }}
          </p>
        </div>
      </div>
    </div>
  </Card>
</template>

