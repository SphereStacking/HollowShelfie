<script setup>

defineProps({
  timeTable: {
    type: Array,
    required: true
  }
})

</script>
<template>
  <div v-if="timeTable.length > 0" class="flex w-full flex-col  justify-center">
    <div class="flex flex-row items-center gap-1">
      <IconTypeMapper type="timeline" class="text-md" />
      <div>timetable</div>
    </div>
    <div class="rounded-xl bg-base-200 p-5">
      <template v-for="(item, index) in timeTable" :key="index">
        <div
          class=" relative flex min-h-24 items-center justify-center gap-5 rounded-xl border-r-2 p-2"
          :class="[
            index % 2 === 0 ? 'bg-base-300' : 'bg-base-100',
            index > 0 && item.start_time !== timeTable[index - 1].end_time ? 'mt-5' : 'mt-0'
          ]">
          <div class="absolute -top-3 right-5 z-10">
            <template v-if="index > 0 && item.start_time !== timeTable[index - 1].end_time">
              {{ item.start_time }}
            </template>
            <template v-else>
              {{ item.start_time }}
            </template>
          </div>
          <div class="absolute -bottom-3 right-5">
            {{ item.end_time }}
          </div>
          <a
            v-for="(performer, index ) in item.performers" :key="index" :href="performer.profile_url"
            class="avatar tooltip h-10 transition-all duration-200 hover:-translate-y-1" :data-tip="performer.name">
            <img :src="performer.image_url" class="h-10 rounded-md">
          </a>
        </div>
      </template>
    </div>
  </div>
</template>
<style>

</style>
