<script setup>

import { Link } from '@inertiajs/vue3'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'

const props = defineProps({
  auth: {
    type: Object,
    required: true,
  },
  counts: {
    type: Object,
    default: () => ({}),
  },
})

const dashboardCategory = [
  { anchorId: 'event', iconType: 'event', title: 'Event' },
  { anchorId: 'social', iconType: 'socialInteraction', title: 'Social' },
  { anchorId: 'team', iconType: 'team', title: 'Team' },
  { anchorId: 'setting', iconType: 'setting', title: 'Setting' },
]

</script>

<template>
  <AppLayout title="Dashboard">
    <template #fixedHeader>
      <h2 class="text-xl font-semibold leading-tight ">
        My Dashboard
      </h2>
    </template>

    <div class="flex size-full flex-row gap-5 md:gap-10">
      <div class="sticky top-40 flex h-full flex-col gap-2">
        <div class="flex flex-col gap-5">
          <div v-for="(category, index) in dashboardCategory" :key="index">
            <a class="btn btn-ghost flex w-full flex-row flex-nowrap items-center justify-center gap-2 text-lg font-semibold md:justify-start" :href="`#${category.anchorId}`">
              <IconTypeMapper :type="category.iconType" class="text-2xl" />
              <span class="hidden md:block">
                {{ category.title }}
              </span>
            </a>
          </div>
        </div>
      </div>
      <div class="flex  grow flex-col gap-5">
        <div id="event" class="scroll-margin-top divider divide-gray-200"></div>
        <div class="grid grid-cols-6 gap-5 md:grid-cols-12">
          <WidgetGood class="col-span-6 md:col-span-4" />
          <WidgetBookmark class="col-span-6 md:col-span-4" />
          <WidgetEventSearch class="col-span-6 md:col-span-4" />
          <WidgetEventManage class="col-span-6 md:col-span-12" />
        </div>
        <div id="social" class="scroll-margin-top divider divide-gray-200"></div>
        <div class="grid grid-cols-6 gap-5 md:grid-cols-12">
          <WidgetFollow class="col-span-6" />
          <WidgetFollower class="col-span-6" />
        </div>
        <div id="team" class="scroll-margin-top divider divide-gray-200"></div>
        <div class="grid grid-cols-6 gap-5 md:grid-cols-12">
          <WidgetTeam class="col-span-6" />
        </div>
        <div id="setting" class="scroll-margin-top divider divide-gray-200"></div>
        <div class="grid grid-cols-6 gap-5 md:grid-cols-12">
          <WidgetAccountSetting class="col-span-6" />
          <WidgetMyProfile class="col-span-6" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.scroll-margin-top {
  scroll-margin-top: 10rem;
}

</style>
