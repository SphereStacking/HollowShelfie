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
  <div class="flex flex-row overflow-hidden overflow-x-auto">
    <!-- 時間を表示 -->
    <div v-for="time in times" class="flex flex-col">
      <div class="text-left">
        <!-- 日にちを表示 -->
        <h2 class="text-xl font-semibold">
          {{ time.date }}
        </h2>
      </div>
      <div class="flex flex-row ">
        <div v-for="hour in time.hours" :key="hour" class="badge mx-1">
          {{ hour }}
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="">

  </style>
