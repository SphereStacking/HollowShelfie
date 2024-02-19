<script setup>
import { Carousel, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

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
        <div v-for="event in events.data" :key="event.id" class="flex flex-col gap-2 rounded-md bg-base-200 p-4">
          <div class="flex flex-row items-center justify-between gap-1">
            <div class="mr-auto flex items-center gap-1  rounded-md">
              <IconTypeMapper type="title" class="shrink-0 text-xl" />
              <p class="text-center text-2xl  font-bold lg:text-left">
                {{ event.title }}
              </p>
            </div>
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
                <a class="btn btn-link btn-xs" :href="route('event.show',event.id)">
                  公開ページ
                </a>
                <a class="btn btn-primary btn-xs" :href="route('event.edit',event.id)">
                  edit
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </PaginationLayout>
  </AppLayout>
</template>

<style lang="">

</style>
