<script setup>
import { getEventPeriod } from '@/Utils/Event'

const props = defineProps({
  event: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['delete', 'duplicate', 'share'])

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
      <div class="tooltip flex w-9/12 items-center gap-1 text-center text-2xl font-bold lg:text-left" :data-tip="event.title">
        <IconTypeMapper type="title" class="shrink-0 text-xl" />
        <p class="truncate">
          {{ event.title }}
        </p>
      </div>
      <div class="flex w-3/12 flex-row justify-end">
        <div class="tooltip tooltip-primary" data-tip="編集">
          <a class="btn btn-square btn-outline btn-primary btn-sm border-0" :href="route('event.edit',event.alias)">
            <IconTypeMapper type="edit" class="shrink-0 text-2xl" />
          </a>
        </div>
        <div class="tooltip tooltip-warning" data-tip="複製">
          <button class="btn btn-square btn-outline btn-warning btn-sm  border-0" @click="emit('duplicate', event)">
            <IconTypeMapper type="duplicate" class="shrink-0 text-2xl" />
          </button>
        </div>
        <div class="tooltip tooltip-error" data-tip="削除">
          <button class="btn btn-square btn-outline btn-error btn-sm  border-0" @click="emit('delete', event)">
            <IconTypeMapper type="delete" class="shrink-0 text-2xl" />
          </button>
        </div>
        <div class="tooltip-neutral tooltip" data-tip="シェア">
          <button class="btn btn-square btn-outline btn-neutral btn-sm  border-0" @click="emit('share', event)">
            <IconTypeMapper type="share" class="shrink-0 text-2xl" />
          </button>
        </div>
      </div>
    </div>

    <div class="grid h-full gap-4 md:grid-cols-2">
      <CarouselGallery :images="event.files.map(file => file.public_url)" />
      <div class="flex flex-col justify-between gap-2 overflow-hidden">
        <div class="flex grow flex-col gap-2">
          <div class="flex flex-row items-center justify-between gap-1">
            <div class="mr-auto flex items-center gap-1  rounded-md">
              <IconTypeMapper type="status" class="shrink-0 text-xl" />
              <BadgeEventStatus :status="event.status" :label="$t(event.status)" />
            </div>
            <div class="mr-auto flex items-center gap-1  rounded-md">
              <IconTypeMapper type="public" class="shrink-0 text-xl" />
              <p class="text-sm font-bold">
                {{ event.published_at ? '公開済み' : '未公開' }}
              </p>
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

        <div class="flex flex-row justify-end gap-1">
          <a class="btn btn-neutral btn-sm" :href="route('event.show',event.alias)">
            <template v-if="event.published_at">
              公開済みページ
            </template>
            <template v-else>
              プレビューページ
            </template>
            <IconTypeMapper type="arrowRight" class="shrink-0 text-xl" />
          </a>
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="">

</style>
