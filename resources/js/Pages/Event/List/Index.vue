<script setup>
import { useForm, Link, router } from '@inertiajs/vue3';

const props = defineProps({
  trendTags: {
    type: Array,
    required: true
  },
  events: {
    type: Array,
    required: true
  },
})

</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-neutral">
        イベントリスト
      </h2>
    </template>
    <div class="mx-auto mt-10 flex max-w-7xl gap-5">
      <div v-for="name in trendTags" :key="tag" @click="appendTagAndNavigate(name)"
        class="badge badge-ghost badge-md mr-1 hover:badge-outline">
        {{ name }}
      </div>
      <div @click="serchResetTag()" class="badge badge-ghost badge-md mr-1 hover:badge-outline">
        Reset
      </div>
    </div>
    <div class="mx-auto mt-10 flex max-w-7xl flex-col gap-5">
      <EventListIndex title="イベント" :events="props.events.data">
        <template #header>
          <BtnPagination :prevPageUrl="props.events.prev_page_url" :nextPageUrl="props.events.links"
            :links="events.links" />
        </template>
        <template #footer>
          <BtnPagination :prevPageUrl="props.events.prev_page_url" :nextPageUrl="props.events.links"
            :links="events.links" />
        </template>
      </EventListIndex>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
