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
  router.get(route('event.list.index'), { section }, { replace: true, preserveState: true })
}

</script>
<template>
  <Card>
    <template #title>
      <div class="flex items-center justify-between w-full">
        <h4 class="text-xl text-gray-900 font-bold">{{ title }}</h4>
        <BtnPrimary @click="getEvetnListSection(section)">show more!</BtnPrimary>
      </div>
    </template>
    <div class=" w-full grid grid-cols-4 gap-6 my-2">
      <CardEvent v-for="(item, index) in events" :key="index" :event="item" />
    </div>
  </Card>
</template>
