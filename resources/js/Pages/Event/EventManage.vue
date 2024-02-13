<script setup>

import file1 from '@/Components/LXIX_Design_224-4.png'
import file2 from '@/Components/LXIX_Design_225-5.png'
import file3 from '@/Components/LXIX_Design_196-4.png'

const image_flyers = [
  file1,
  file2,
  file3,
]

defineProps({
  events: {
    type: Array,
    required: true
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
      <div>イベント管理</div>
    </div>

    <PaginationLayout :pagination="events.pagination">
      <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <div v-for="event in events.data" :key="event.id" class="rounded-md bg-base-200 p-4">
          <div class="flex w-full flex-col gap-10 lg:flex-row ">
            <div class="">
              <div class="relative h-48 w-48 bg-base-300">
                <div class=" absolute left-0 top-0">
                  {{ event.status }}
                </div>
                <!-- <img :src="dataile.photo_url" class="absolute mx-auto h-full rounded-lg bg-base-300 shadow-2xl"> -->
              </div>
            </div>
            <div class="flex w-full flex-col justify-between">
              <div>
                <div class="text-center text-2xl  font-bold lg:text-left">
                  {{ event.title }}
                </div>
                <p class="text-xs">
                  {{ event.start_date }}~{{ event.end_date }}
                </p>
                <div>
                  {{ event.category_name }}
                </div>
                <div>
                  {{ event.tags }}
                </div>
              </div>

              <a class="btn btn-primary" :href="route('event.edit',event.id)">
                編集
              </a>
            </div>
          </div>
        </div>
      </div>
    </PaginationLayout>
  </AppLayout>
</template>

<style lang="">

</style>
