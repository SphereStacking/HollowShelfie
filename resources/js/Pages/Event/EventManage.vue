<script setup>
import {router, usePage, Link } from '@inertiajs/vue3'

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
const modalEventDuplicate =ref(null)
const text = ref('')
const conditions = ref([])
const order = ref('')

const orderMaps = [
  { type: 'new', icon: 'new', label: 'new' },
  { type: 'good', icon: 'good', label: 'good' },
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
  <AppLayout title="Event Management">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        Event Management
      </h2>
    </template>
    <Link class="btn btn-info btn-sm" :href="route('event.create')">
      <span class="flex items-center">
        イベントを主催する！
        <IconTypeMapper type="arrowRight" class="text-xl" />
      </span>
    </Link>
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
            <IconTypeMapper type="sort" class="text-xl transition-all" />
            <div v-if="order.icon" class="badge indicator-item badge-info">
              <IconTypeMapper :type="order.icon" class="text-sm" />
            </div>
          </div>
          <ul tabindex="0" class="menu dropdown-content z-[1] w-28 rounded-box bg-base-100 p-2 shadow">
            <li v-for="(orderItem, index) in orderMaps" :key="index" @click="order = orderItem; executeSearch()">
              <div>
                <IconTypeMapper :type="orderItem.icon" class="text-xl transition-all" />
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
            @delete="modalEventDestroy.onBtnOpenModal(event)"
            @duplicate="modalEventDuplicate.onBtnOpenModal(event)" />
        </transition-group>
      </div>
    </PaginationLayout>
    <ModalEventDestroyConfirm ref="modalEventDestroy" />
    <ModalEventDuplicateConfirm ref="modalEventDuplicate" />
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
