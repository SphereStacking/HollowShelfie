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
          <div v-for="event in events.data" :key="event.id" class="flex flex-col gap-2 rounded-md bg-base-200 p-4">
            <div class="flex flex-row items-center justify-between gap-1">
              <div class="mr-auto flex items-center gap-1  rounded-md">
                <IconTypeMapper type="title" class="shrink-0 text-xl" />
                <p class="text-center text-2xl  font-bold lg:text-left">
                  {{ event.title }}
                </p>
              </div>
              <button class="btn btn-square btn-outline btn-error btn-sm  border-0" @click="modalEventDestroy.onBtnOpenModal(event)">
                <IconTypeMapper type="delete" class="shrink-0 text-2xl" />
              </button>
            </div>

            <div class="grid h-full gap-4 lg:grid-cols-2">
              <CarouselGallery :images="event.files.map(file => file.public_url)" />
              <div class="flex flex-col justify-between gap-2">
                <div class="flex flex-col justify-between gap-2">
                  <div class="flex flex-row items-center gap-1">
                    <div class="mr-auto flex items-center gap-1  rounded-md">
                      <IconTypeMapper type="status" class="shrink-0 text-xl" />
                      <div class=" left-0 top-0 z-10">
                        <BadgeEventStatus :status="event.status" :label="event.status_label" />
                      </div>
                    </div>
                  </div>
                  <div class="flex flex-row items-center gap-1">
                    <IconTypeMapper type="date" class="shrink-0 text-xl" />
                    <p class="text-xs">
                      {{ event.formatted_start_date.year }}/{{ event.formatted_start_date.month }}/{{ event.formatted_start_date.day }}
                      [{{ event.formatted_start_date.weekday }}]
                      {{ event.formatted_start_date.time }}-{{ event.formatted_end_date.time }}
                    </p>
                  </div>
                  <div class="flex flex-row gap-1">
                    <IconTypeMapper type="category" class="shrink-0 text-xl" />
                    <div class="flex flex-row flex-wrap gap-1">
                      <BtnConditionTypeMapper
                        v-for="(category_name, index) in event.category_names" :key="index" type="category"
                        class="no-animation">
                        {{ category_name }}
                      </BtnConditionTypeMapper>
                    </div>
                  </div>
                  <div class="flex flex-row gap-1">
                    <IconTypeMapper type="tag" class="shrink-0 text-xl" />
                    <div class="flex flex-row flex-wrap gap-1">
                      <BtnConditionTypeMapper
                        v-for="(tag, index) in event.tags" :key="index" type="tag"
                        class="no-animation">
                        {{ tag }}
                      </BtnConditionTypeMapper>
                    </div>
                  </div>
                  <div class="flex flex-row gap-1">
                    <div class="mr-auto flex items-center gap-1  rounded-md">
                      <IconTypeMapper type="good" class="shrink-0 text-xl" />
                      {{ event.short_good_count }}
                    </div>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                  <a class="btn btn-link btn-xs" :href="route('event.show',event.alias)">
                    公開ページ
                  </a>
                  <a class="btn btn-primary btn-xs" :href="route('event.edit',event.alias)">
                    edit
                  </a>
                </div>
              </div>
            </div>
          </div>
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
