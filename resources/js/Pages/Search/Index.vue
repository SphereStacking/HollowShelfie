<script setup>
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

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
  );
};

onMounted(() => {
  const query = usePage().props.ziggy.query;
  if (query.order) {
    order.value = orderMaps.find(orderItem => orderItem.type === query.order);
  }
});

</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
      </h2>
    </template>
    <div class="max-w-6xl flex flex-col gap-2 mx-auto">
      <SearchForm v-model="conditions" v-model:text="text" :instanceTypes="instanceTypes" :statuses="statuses"
        :categories="categories" :tags="trendTags" @executeSearch="executeSearch()">
      </SearchForm>
    </div>

    <div class="mx-auto flex max-w-7xl flex-col gap-5">
      <div class="flex flex-row  justify-between">
        <div class="">
          {{ events.pagination.total }} 件
        </div>
        <div class=" flex flex-row gap-2">
          <BtnPagination :prevPageUrl="props.events.pagination.prev_page_url" :nextPageUrl="props.events.pagination.links"
            :links="events.pagination.links" />
          <div class="dropdown dropdown-end ">
            <div tabindex="0" class=" btn btn-sm  btn-neutral px-2 w-16 indicator">
              <Icon icon="mdi:sort" class="text-xl transition-all"></Icon>
              <div v-if="order.icon" class="indicator-item badge badge-info">
                <Icon :icon="order.icon" class=" text-sm "></Icon>
              </div>
            </div>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-28">
              <li v-for="(orderItem, index) in orderMaps" :key="index" @click="order = orderItem; executeSearch()">
                <div>
                  <Icon :icon="orderItem.icon"></Icon>
                  {{ orderItem.label }}
                </div>
              </li>
            </ul>
          </div>
        </div>

      </div>
      <div class="w-full grid xl:grid-cols-6 md:grid-cols-4  sm:grid-cols-3 grid-cols-2  gap-6 my-2">
        <CardEvent v-for="(item, index) in props.events.data" :key="index" :event="item" scroll-region />
      </div>
      <div class="flex flex-row justify-center">
        <BtnPagination :prevPageUrl="props.events.pagination.prev_page_url" :nextPageUrl="props.events.pagination.links"
          :links="events.pagination.links" />
      </div>
    </div>

  </AppLayout>
</template>

<style lang="">

</style>
