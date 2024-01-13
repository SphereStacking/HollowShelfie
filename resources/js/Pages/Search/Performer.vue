<script setup>
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  trendTags: {
    type: Array,
    required: true
  },
  categories: {
    type: Array,
    required: true
  },
  statuses: {
    type: Object,
    required: true
  },
  instanceTypes: {
    type: Array,
    required: true
  },
  events: {
    type: Array,
    required: true
  },
})

const text = ref('')
const conditions = ref([])
const order = ref('')

const orderMaps = [
  { type: 'new', icon: 'mdi:new-box', label: 'new' },
  { type: 'good', icon: 'mdi:thumb-up', label: 'good' },
  // { type: 'views', icon: 'mdi:eye', label: 'view' },
  // { type: 'trend', icon: 'mdi:fire', label: 'trend' },
]
const executeSearch = () => {
  router.visit(
    route('event.search.index',
      { t: text.value, q: conditions.value, o: order.value.type, }
    )
  )
}

onMounted(() => {
  const queryParams = usePage().props.ziggy.query
  if (queryParams.o) {
    order.value = orderMaps.find(orderItem => orderItem.type === queryParams.o)
  }
})

</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
      </h2>
    </template>
    <div class="mx-auto flex max-w-6xl flex-col gap-2">
      <SearchForm
        v-model="conditions" v-model:text="text" :instance-types="instanceTypes"
        :statuses="statuses"
        :categories="categories" :tags="trendTags" @execute-search="executeSearch()" />
    </div>

    <div class="mx-auto flex max-w-7xl flex-col gap-5">
      <div class="flex flex-row  justify-between">
        <div class="">
          {{ events.pagination.to }} / {{ events.pagination.total }}
        </div>
        <div class=" flex flex-row gap-2">
          <BtnPagination
            :prev-page-url="props.events.pagination.prev_page_url" :next-page-url="props.events.pagination.links"
            :links="events.pagination.links" />
          <div class="dropdown dropdown-end ">
            <div tabindex="0" class=" btn indicator  btn-neutral btn-sm w-16 px-2">
              <Icon icon="mdi:sort" class="text-xl transition-all" />
              <div v-if="order.icon" class="badge indicator-item badge-info">
                <Icon :icon="order.icon" class=" text-sm " />
              </div>
            </div>
            <ul tabindex="0" class="menu dropdown-content z-[1] w-28 rounded-box bg-base-100 p-2 shadow">
              <li v-for="(orderItem, index) in orderMaps" :key="index" @click="order = orderItem; executeSearch()">
                <div>
                  <Icon :icon="orderItem.icon" />
                  {{ orderItem.label }}
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="my-2 grid w-full grid-cols-2  gap-6 sm:grid-cols-3  md:grid-cols-4 xl:grid-cols-6">
        <CardEvent
          v-for="(item, index) in props.events.data" :key="index" :event="item"
          scroll-region />
      </div>
      <div class="flex flex-row justify-center">
        <BtnPagination
          :prev-page-url="props.events.pagination.prev_page_url" :next-page-url="props.events.pagination.links"
          :links="events.pagination.links" />
      </div>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
