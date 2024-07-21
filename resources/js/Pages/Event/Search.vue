<script setup>

import { router, usePage } from '@inertiajs/vue3'
import { markRaw } from 'vue'
import SearchForm from '@/Pages/Event/Partials/EventSearch/SearchForm.vue'

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
    type: Object,
    required: true
  },
})

const text = ref('')
const conditions = ref([])
const order = ref('')
const modalEventShare = ref(null)

const orderMaps = [
  { type: 'new', icon: 'new', label: 'new' },
  { type: 'good', icon: 'good', label: 'good' },
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

const RawSearchForm = markRaw(SearchForm)

</script>

<template>
  <AppLayout title="Event Search">
    <ModalEventShareConfirm ref="modalEventShare" />
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        Event Search
      </h2>
    </template>
    <div class="mx-auto flex max-w-6xl flex-col gap-2">
      <RawSearchForm
        v-model="conditions" v-model:text="text" :instance-types="instanceTypes"
        :statuses="statuses"
        :categories="categories" :tags="trendTags" @execute-search="executeSearch()" />
    </div>
    <PaginationLayout :pagination="events.pagination">
      <template #TopPaginationRight>
        <BtnDropdown class="dropdown-end" width="w-28">
          <template #trigger>
            <div class=" btn indicator  btn-sm w-16 px-2">
              <IconTypeMapper type="sort" class="text-xl transition-all" />
              <div v-if="order.icon" class="badge indicator-item badge-info">
                <IconTypeMapper :type="order.icon" class="text-sm" />
              </div>
            </div>
          </template>
          <BtnDropdownItem v-for="(orderItem, index) in orderMaps" :key="index">
            <div @click="order = orderItem; executeSearch()">
              <IconTypeMapper :type="orderItem.icon" class="text-xl transition-all" />
              {{ orderItem.label }}
            </div>
          </BtnDropdownItem>
        </BtnDropdown>
      </template>
      <div class="my-2 grid w-full grid-cols-2  gap-2 sm:grid-cols-2  md:grid-cols-3 xl:grid-cols-4">
        <CardEvent
          v-for="(item, index) in props.events.data"
          :key="index" :event="item"
          class="my-2"
          scroll-region
          @share="modalEventShare.onBtnOpenModal(item)" />
      </div>
    </PaginationLayout>
  </AppLayout>
</template>

<style lang="">

</style>
