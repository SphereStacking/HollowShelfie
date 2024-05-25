<script setup>
import { formattedToBrowserTz} from '@/Utill/Date'

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
          class=" relative flex min-h-24 items-center justify-start gap-5 rounded-xl border-r-2 p-2"
          :class="[
            index % 2 === 0 ? 'bg-base-300' : 'bg-base-100',
            index > 0 && item.start_date !== timeTable[index - 1].end_date ? 'mt-5' : 'mt-0'
          ]">
          <div class="absolute -top-3 right-5 z-10 font-black italic">
            <template v-if="index > 0 && item.start_date !== timeTable[index - 1].end_date">
              {{ formattedToBrowserTz(item.start_date, 'HH:mm') }}
            </template>
            <template v-else>
              {{ formattedToBrowserTz(item.start_date, 'HH:mm') }}
            </template>
          </div>
          <div class="absolute -bottom-3 right-5 font-black italic">
            {{ formattedToBrowserTz(item.end_date, 'HH:mm') }}
          </div>

          <div class="flex w-11/12 flex-row items-center gap-0.5">
            <div class="flex w-9/12 flex-row items-center justify-center gap-5">
              <AvatarLink
                v-for="(performer, index ) in item.performers" :key="index" :href="performer.profile_url"
                class="tooltip transition-all duration-200 hover:-translate-y-1" :data-tip="performer.name"
                :image-url="performer.image_url" :name="performer.name" />
            </div>
            <div class="w-3/12 text-left text-xs">
              {{ item.description }}
            </div>
          </div>
          <div class="w-1/12"></div>
        </div>
      </template>
    </div>
  </div>
</template>
<style>

</style>
