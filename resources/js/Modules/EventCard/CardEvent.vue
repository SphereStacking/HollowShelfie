
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
  <div class=" flex flex-col justify-start border border-transparent">
    <div class="flex flex-col justify-start border border-transparent">
      <div class="group relative aspect-a4 min-w-40 overflow-hidden rounded-md bg-base-300 shadow-md shadow-base-200 transition-all duration-200 hover:cursor-pointer hover:shadow-lg hover:shadow-neutral-500">
        <template v-if="event.files.length>0">
          <div class="size-full scale-90">
            <SwiperWrapper
              class="absolute left-1/2 top-1/2 size-full -translate-x-1/2 -translate-y-1/2 cursor-pointer select-none transition-all delay-150 duration-200 group-hover:left-2/4 group-hover:top-1/4 group-hover:scale-50"
              :loop="event.files.length > 1"
              :slides-per-view="1"
              :model-value="event.files"
              watch-slides-progress="true"
              :scrollbar="false"
              slide-class="px-1 w-full">
              <template #item="{element, index}">
                <div class="flex size-full items-center justify-center">
                  <FlyerImg
                    :key="index"
                    class="cursor-pointer select-none"
                    :src="element.public_url" />
                </div>
              </template>
            </SwiperWrapper>
            <div class="absolute right-1 top-1 z-50 hidden flex-col items-center justify-center gap-0.5 group-hover:flex">
              <div class="tooltip tooltip-left" data-tip="link">
                <Link :href="route('event.show', event.alias)" class="btn btn-square btn-neutral btn-sm">
                  <IconTypeMapper type="link" class="size-8 p-1" />
                </Link>
              </div>
            </div>
            <div class="absolute bottom-0 left-1/2 h-1/2 w-full -translate-x-1/2  translate-y-1/2 overflow-hidden opacity-0 transition-all delay-150 duration-200 group-hover:translate-y-0 group-hover:opacity-100">
              <!-- organizers -->
              <div v-if="event.organizers.length > 0" class="flex w-full flex-col justify-start gap-1">
                <div class="flex flex-row items-center gap-1">
                  <IconTypeMapper type="organizer" class="text-md" />
                  <div>organizers</div>
                </div>
                <SwiperWrapper
                  :loop="event.organizers.length > 1"
                  :model-value="event.organizers"
                  slides-per-view="auto"
                  watch-slides-progress="true"
                  :scrollbar="true"
                  slide-class="px-0.5 py-1 w-fit">
                  <template #item="{element, index}">
                    <AvatarLink
                      :key="index"
                      size="size-10" :href="element.profile_url"
                      :image-url="element.image_url" :name="element.name" />
                  </template>
                </SwiperWrapper>
              </div>
              <!-- performers -->
              <div v-if="event.performers.length > 0" class="flex flex-col justify-center gap-1">
                <div class="flex flex-row items-center gap-1">
                  <IconTypeMapper type="performer" class="text-md" />
                  <div>performers</div>
                </div>
                <SwiperWrapper
                  :loop="event.performers.length > 1"
                  :model-value="event.performers"
                  slides-per-view="auto"
                  watch-slides-progress="true"
                  :scrollbar="true"
                  slide-class="px-0.5 py-1 w-fit">
                  <template #item="{element, index}">
                    <AvatarLink
                      :key="index" size="size-10" :href="element.profile_url"
                      :image-url="element.image_url" :name="element.name" />
                  </template>
                </SwiperWrapper>
              </div>
            </div>
          </div>
        </template>
        <template v-else>
          <div class="size-full bg-base-300">
            <IconTypeMapper type="imageOff" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-6xl" />
          </div>
        </template>
      </div>
      <div class="tooltip tooltip-top tooltip-accent mx-2 mt-0.5 flex flex-row justify-between" :data-tip="event.title">
        <Link
          :href="route('event.show', event.alias)"
          class="truncate whitespace-nowrap text-left text-lg font-bold transition-all delay-150 duration-200 hover:text-accent hover:underline">
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
