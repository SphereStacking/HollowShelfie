<script setup>
import { getEventPeriod } from '@/Utill/Event'

const props = defineProps({
  event: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['delete'])

const formatDate = computed(() => {
  if (!props.event.start_date || !props.event.end_date) {
    return ''
  }
  return getEventPeriod(props.event.start_date, props.event.end_date)
})

</script>
<template lang="">
  <div class="flex flex-col gap-2 rounded-md bg-base-200 p-4">
    <div class="flex flex-row items-center justify-between gap-1">
      <div class="mr-auto flex items-center gap-1  rounded-md">
        <IconTypeMapper type="title" class="shrink-0 text-xl" />
        <p class="text-center text-2xl  font-bold lg:text-left">
          {{ event.title }}
        </p>
      </div>
      <button class="btn btn-square btn-outline btn-error btn-sm  border-0" @click="emit('delete', event)">
        <IconTypeMapper type="delete" class="shrink-0 text-2xl" />
      </button>
    </div>

    <div class="grid h-full gap-4 lg:grid-cols-2">
      <CarouselGallery :images="event.files.map(file => file.public_url)" />
      <div class="flex flex-col justify-between gap-2">
        <div class="flex grow flex-col gap-2">
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
              {{ formatDate }}
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

        <div class="grid grid-cols-2 items-center gap-2">
          <a class="btn btn-link btn-md" :href="route('event.show',event.alias)">
            公開ページ
          </a>
          <a class="btn btn-primary btn-sm " :href="route('event.edit',event.alias)">
            edit
          </a>
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="">

</style>
