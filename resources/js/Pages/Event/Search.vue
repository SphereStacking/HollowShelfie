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
const direction = ref('')
const modalEventShare = ref(null)

const searchTimeoutId = ref(null)
const executeSearch = () => {
  clearTimeout(searchTimeoutId.value)
  searchTimeoutId.value = setTimeout(() => {
    router.visit(
      route('event.search.index',
        {
          d: direction.value,
          o: order.value,
          q: conditions.value,
          t: text.value,
        }
      )
    )
  }, 500)
}

onMounted(() => {
  const queryParams = usePage().props.ziggy.query
  order.value = queryParams.o || ''
  direction.value = queryParams.d || ''
  conditions.value = queryParams.q || []
  text.value = queryParams.t || ''
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
    <div class="mx-auto flex max-w-7xl flex-col gap-2">
      <RawSearchForm
        v-model="conditions" v-model:text="text" :instance-types="instanceTypes"
        :statuses="statuses"
        :categories="categories" :tags="trendTags" @execute-search="executeSearch()" />
      <PaginationLayout :pagination="events.pagination">
        <template #TopPaginationRight>
          <OrderSelection v-model="order" @update:model-value="executeSearch" />
          <DirectionSelection v-model="direction" @update:model-value="executeSearch" />
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
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
