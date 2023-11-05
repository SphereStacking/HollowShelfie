<script setup>
const props = defineProps({
  times: {
    type: Array,
    required: true
  },
})
defineEmits(
  ['click']
)
console.log(props.times)
</script>
<template>
  <div class="overflow-hidden flex flex-row overflow-x-auto">
    <!-- 時間を表示 -->
    <div v-for="time in times" class="flex flex-col">
      <div class="text-left">
        <!-- 日にちを表示 -->
        <h2 class="text-xl font-semibold">{{ time.date }}</h2>
      </div>
      <div class="flex flex-row ">
        <div class="mx-1 badge" v-for="hour in time.hours" :key="hour">{{ hour }}</div>
      </div>
    </div>
  </div>
</template>

<style lang="">

  </style>
