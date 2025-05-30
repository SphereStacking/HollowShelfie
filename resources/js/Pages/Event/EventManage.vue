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
    type: Object,
    required: true
  }
})

const modalEventShare = ref(null)
const modalEventDestroy = ref(null)
const modalEventDuplicate = ref(null)
const text = ref('')
const conditions = ref([])
const order = ref('')
const direction = ref('')

const searchTimeoutId = ref(null)
const executeSearch = () => {
  clearTimeout(searchTimeoutId.value)
  searchTimeoutId.value = setTimeout(() => {
    router.visit(
      route('event.manage',
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
</script>

<template>
  <AppLayout title="Event Management">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        Event Management
      </h2>
    </template>

    <div class="mx-auto flex max-w-6xl flex-col gap-2">
      <div>
        <Link class="btn btn-info btn-sm" :href="route('event.create')">
          <span class="flex items-center">
            イベントを主催する！
            <IconTypeMapper type="arrowRight" class="text-xl" />
          </span>
        </Link>
      </div>

      <SearchForm
        v-model="conditions" v-model:text="text" :instance-types="instanceTypes"
        :statuses="statuses"
        :categories="categories" @execute-search="executeSearch()" />
      <PaginationLayout :pagination="events.pagination">
        <template #TopPaginationRight>
          <OrderSelection v-model="order" @update:model-value="executeSearch" />
          <DirectionSelection v-model="direction" @update:model-value="executeSearch" />
        </template>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
          <transition-group name="list">
            <ManageEventCard
              v-for="event in events.data" :key="event"
              :event="event"
              @share="modalEventShare.onBtnOpenModal(event)"
              @delete="modalEventDestroy.onBtnOpenModal(event)"
              @duplicate="modalEventDuplicate.onBtnOpenModal(event)" />
          </transition-group>
        </div>
      </PaginationLayout>
  </div>

    <ModalEventShareConfirm ref="modalEventShare" />
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
