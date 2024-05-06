<script setup>

defineProps({
  events: {
    type: Array,
    required: true,
  },
  startDate: {
    type: Date,
    required: true,
  },
  endDate: {
    type: Date,
    required: true,
  },
})

</script>
<template>
  <AppLayout title="Event TimeLine">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        Event TimeLine
      </h2>
    </template>
    <EventTimeline :events="events" :start-date="startDate" :end-date="endDate" />
  </AppLayout>
</template>
<style>
</style>
