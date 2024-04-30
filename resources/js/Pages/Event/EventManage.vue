<script setup>
import {router, usePage } from '@inertiajs/vue3'

defineProps({
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
  }
})

const modalEventDestroy =ref(null)
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
    route('event.manage',
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
        イベント
      </h2>
    </template>
    <div class="mx-auto mt-2 flex max-w-7xl flex-col gap-2">
      イベント管理
    </div>

    <div class="mx-auto flex max-w-6xl flex-col gap-2">
      <SearchForm
        v-model="conditions" v-model:text="text" :instance-types="instanceTypes"
        :statuses="statuses"
        :categories="categories" @execute-search="executeSearch()" />
    </div>
    <PaginationLayout :pagination="events.pagination">
      <template #TopPaginationRight>
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
      </template>
      <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <transition-group name="list">
          <ManageEventCard
            v-for="event in events.data" :key="event"
            :event="event"
            @delete="modalEventDestroy.onBtnOpenModal(event)" />
        </transition-group>
      </div>
    </PaginationLayout>
    <ModalEventDestroyConfirm ref="modalEventDestroy" />
  </AppLayout>
</template>

<style scoped>
.list-move, /* 移動する要素にトランジションを適用 */
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

/* leave する項目をレイアウトフローから外すことで
   アニメーションが正しく計算されるようになる */
.list-leave-active {
  position: absolute;
}
</style>
