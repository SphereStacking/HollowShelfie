<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  events: {
    type: String,
    required: true
  },
  section: {
    type: String,
    required: true
  },
})
defineEmits(
  ['click']
)

const getEvetnListSection = (section) => {
  router.get(route('event.search.index'), { section }, { replace: true, preserveState: true })
}

</script>
<template>
  <div class="mx-2">
    <div class="flex items-center justify-between w-full">
      <h4 class="text-xl font-bold">{{ title }}</h4>
    </div>
    <div class="w-full grid xl:grid-cols-6 md:grid-cols-4  sm:grid-cols-3 grid-cols-2  gap-6 my-2">
      <CardEvent v-for="(item, index) in events" :key="index" :event="item" scroll-region />
    </div>
    <BtnPrimary @click="getEvetnListSection(section)">show more!</BtnPrimary>
  </div>
</template>
