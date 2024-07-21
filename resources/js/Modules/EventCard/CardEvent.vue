
<script setup>
import { Link, router} from '@inertiajs/vue3'
import { decomposeDate } from '@/Utils/Date'
import { getYear } from 'date-fns'
const props = defineProps({
  event: {
    type: Object,
    required: true
  },
})
const currentImageIndex = ref(0)

const emit = defineEmits(['share'])

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
      <Link :href="route('event.show', event.alias)" class="  relative aspect-a4 min-w-40 rounded-md bg-base-300 shadow-md shadow-base-200 transition-all duration-300 hover:cursor-pointer hover:shadow-lg hover:shadow-neutral-500">
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
      </Link>
      <div class="tooltip tooltip-top tooltip-accent mx-2 mt-0.5 flex flex-row justify-between" :data-tip="event.title">
        <Link
          :href="route('event.show', event.alias)"
          class="truncate whitespace-nowrap text-left text-lg font-bold transition-all duration-200 hover:text-accent hover:underline">
          {{ event.title }}
        </Link>

        <BtnDropdown width="w-32" class="dropdown-end">
          <template #trigger>
            <button class="btn btn-ghost btn-xs p-0">
              <IconTypeMapper type="overflowMenu" class="text-xl" />
            </button>
          </template>
          <BtnDropdownItem>
            <BtnSwapEventGood
              class="btn justify-start"
              :event-id="event.alias" :check="event.auth_user?.is_good" :count="event.short_good_count">
              Good
            </BtnSwapEventGood>
          </BtnDropdownItem>
          <BtnDropdownItem>
            <BtnSwapEventBookmark class="btn justify-start" :event-id="event.alias" :check="event.auth_user?.is_bookmark">
              Bookmark
            </BtnSwapEventBookmark>
          </BtnDropdownItem>
          <BtnDropdownItem>
            <button class="btn btn-xs justify-start px-1" @click="emit('share')">
              <IconTypeMapper type="share" class="text-lg" />
              Share
            </button>
          </BtnDropdownItem>
        </BtnDropdown>
      </div>

      <div class="mx-2 flex items-center justify-between gap-1 text-xs font-thin">
        <div class="flex items-center gap-1">
          <IconTypeMapper type="status" />
          <button
            class="btn btn-ghost btn-xs px-0.5 py-0 text-xs"
            @click="navigateToType(event.status, 'status')">
            {{ $t(event.status) }}
          </button>
          <button class="btn btn-ghost btn-xs px-0.5 text-xs">
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
      <div class="mx-2 flex flex-wrap items-center gap-1 overflow-hidden text-xs">
        <IconTypeMapper type="category" />
        <button
          v-for="(category, index) in event.category_names" :key="index" class="btn btn-ghost btn-xs px-0.5 py-0 text-xs"
          @click="navigateToType(category, 'category')">
          {{ category }}
        </button>
      </div>
      <div class="mx-2 flex flex-wrap items-center gap-1 overflow-hidden text-xs">
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
