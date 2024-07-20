<script setup>

defineProps({
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

const columnWidthRem = ref(2.5)
</script>
<template>
  <AppLayout title="Event TimeLine">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        Event TimeLine
      </h2>
    </template>
    <div class="flex items-center justify-end">
      <div class="w-full rounded-xl border border-neutral bg-base-300 p-4 text-center  shadow-md md:w-1/4">
        <label for="columnWidthRange" class="mb-0.5 block text-sm font-medium text-gray-700">
          1時間の幅
        </label>
        <div class="flex w-full justify-between px-2 text-xs">
          <span>|</span>
          <span>|</span>
          <span>|</span>
          <span>|</span>
          <span>|</span>
          <span>|</span>
          <span>|</span>
        </div>
        <input
          v-model.number="columnWidthRem" type="range" min="1"
          max="4"
          class="range range-sm" step="0.5">
      </div>
    </div>
    <div class="mt-1 rounded-lg bg-base-300/10 p-2">
      <EventTimeline
        :events="events" :start-date="startDate" :end-date="endDate"
        :column-width-rem="columnWidthRem" />
    </div>
  </AppLayout>
</template>
<style>
</style>
