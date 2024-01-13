<script setup>
const props = defineProps({
  events: {
    type: Array,
    required: true
  },
})

const order = ref('')

const orderMaps = [
  { type: 'new', icon: 'mdi:new-box', label: 'new' },
  { type: 'old', icon: 'mdi:alpha-o-box', label: 'old' },
]
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        ダッシュボード
      </h2>
    </template>
    ぶっくまーく
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
