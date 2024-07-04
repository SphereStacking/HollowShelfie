<script setup>

const modalEventShare = ref(null)

const props = defineProps({
  events: {
    type: Array,
    required: true
  },
})

</script>

<template>
  <AppLayout title="Dashboard">
    <ModalEventShareConfirm ref="modalEventShare" mode="participant" />
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        Bookmark
      </h2>
    </template>
    <div class="mx-auto flex max-w-7xl flex-col gap-5">
      <div class="flex flex-row  justify-between">
        <div class="">
          {{ events.pagination.to }} / {{ events.pagination.total }}
        </div>
        <div class=" flex flex-row gap-2">
          <BtnPagination
            :prev-page-url="props.events.pagination.prev_page_url" :next-page-url="props.events.pagination.links"
            :links="events.pagination.links" />
        </div>
      </div>
      <div class="my-2 grid w-full grid-cols-2  gap-6 sm:grid-cols-3  md:grid-cols-4 xl:grid-cols-6">
        <CardEvent
          v-for="(item, index) in props.events.data"
          :key="index" :event="item" scroll-region
          @share="modalEventShare.onBtnOpenModal(item)" />
      </div>
      <div class="flex flex-row justify-center">
        <BtnPagination
          :links="events.pagination.links" />
      </div>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
