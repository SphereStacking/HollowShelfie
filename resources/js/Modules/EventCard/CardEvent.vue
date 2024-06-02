
<script setup>
import { Link, router} from '@inertiajs/vue3'
import { getEventPeriod } from '@/Utils/Event'
import { decomposeDate } from '@/Utils/Date'
import { getYear } from 'date-fns'
const props = defineProps({
  event: {
    type: Object,
    required: true
  },
})
const currentImageIndex = ref(0)

const incrementImageIndex = () => {
  if (props.event.files.length > 0) {
    currentImageIndex.value = (currentImageIndex.value + 1) % props.event.files.length
  }
}

const shareData = computed(() => {
  return {
    title: props.event.title,
    period: getEventPeriod(props.event.start_date, props.event.end_date),
    instances: props.event.instances.map((instance) => instance.instance_type_name),
    organizers: props.event.organizers.map((organizer) => organizer.name),
    performers: props.event.performers.map((performer) => performer.name),
    category_names: props.event.category_names,
    tags: props.event.tags.map((tag) => tag),
    route: route('event.show', props.event.alias),
  }
})

const navigateToType = (searchValue, type) => {
  const value = [
    { include: 'and', type: type, value: searchValue },
  ]
  router.visit(
    route('event.search.index',
      { t: '', q: value, o: '', }
    )
  )
}
const currentYear = new Date().getFullYear()
const eventYear = computed(() => getYear(props.event.start_date))

const startDate = computed(() => {
  return decomposeDate(props.event.start_date)
})

const isCurrentYear = computed(() => {
  return eventYear.value === currentYear
})

</script>

<template>
  <div class="flex flex-col justify-start border border-transparent">
    <div class="flex flex-col justify-start border border-transparent">
      <div class=" relative aspect-a4 min-w-40 rounded-md bg-base-300 shadow-md shadow-base-200" @click.prevent="incrementImageIndex">
        <template v-if="event.files.length>0">
          <TransitionGroup
            enter-active-class="transition-all duration-300"
            leave-active-class="transition-all duration-100"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <FryerImg
              v-for="(image, index) in event.files" v-show="index === currentImageIndex"
              :key="index"
              class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 scale-90 cursor-pointer select-none"
              :src="image.public_url" />
          </TransitionGroup>
        </template>
        <template v-else>
          <div class="size-full bg-base-300">
            <IconTypeMapper type="imageOff" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-6xl" />
          </div>
        </template>
        <div class="absolute bottom-0 left-1 flex w-full justify-start gap-1">
          <div v-for="(instance, index) in event.files" :key="index">
            <div class="select-none">
              {{ index === currentImageIndex ? '•' : '-' }}
            </div>
          </div>
        </div>
      </div>
      <div class="mt-0.5 flex flex-row justify-between">
        <Link :href="route('event.show', event.alias)" class=" mx-2 truncate whitespace-nowrap text-lg font-bold transition-all duration-200 hover:text-accent hover:underline">
          {{ event.title }}
        </Link>
        <div class="flex flex-row gap-1">
          <BtnSwapEventGood
            :event-id="event.alias" :check="event.auth_user?.is_good" :count="event.short_good_count"
            show-count />
          <div class="dropdown dropdown-end dropdown-bottom">
            <div tabindex="0" role="button" class="btn btn-ghost btn-xs p-0">
              <IconTypeMapper type="overflowMenu" class="text-xl" />
            </div>
            <ul tabindex="0" class="menu dropdown-content z-[1] w-auto rounded-box bg-base-200 p-2 shadow">
              <li>
                <BtnSwapEventBookmark :event-id="event.alias" :check="event.auth_user?.is_bookmark" />
              </li>
              <li>
                <BtnSnsShareEventToX
                  :title="shareData.title" :period="shareData.period" :instance-names="shareData.instances"
                  :organizer-names="shareData.organizers" :performer-names="shareData.performers" :category-names="shareData.category_names"
                  :tags="shareData.tags" :url="shareData.route" />
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="mx-2 flex items-center justify-between gap-1 text-xs font-thin">
        <div class="flex items-center gap-1">
          <IconTypeMapper type="status" />
          <button class="btn btn-ghost btn-xs px-0.5 text-xs">
            {{ $t(event.status) }}
          </button>
        </div>
        <div class="flex items-center gap-1">
          <IconTypeMapper type="clock" />
          <div v-if="isCurrentYear">
            {{ startDate.month }}/{{ startDate.day }} {{ startDate.hour }}:{{ startDate.minute }}
          </div>
          <div v-else>
            {{ startDate.year }}/{{ startDate.month }}/{{ startDate.day }} {{ startDate.hour }}:{{ startDate.minute }}
          </div>
        </div>
      </div>
      <div class="mx-2 flex flex-wrap items-center gap-1 text-xs">
        <IconTypeMapper type="category" />
        <button
          v-for="(category, index) in event.category_names" :key="index" class="btn btn-ghost btn-xs px-0.5 py-0 text-xs"
          @click="navigateToType(category, 'category')">
          {{ category }}
        </button>
      </div>
      <div class="mx-2 flex flex-wrap items-center gap-1 text-xs">
        <IconTypeMapper type="tag" />
        <button
          v-for="(tag, index) in event.tags" :key="index" class="btn btn-ghost btn-xs px-0.5 py-0 text-xs"
          @click="navigateToType(tag, 'tag')">
          {{ tag }}
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
