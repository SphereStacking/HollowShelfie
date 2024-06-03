<script setup>
import { router } from '@inertiajs/vue3'
import { decomposeDate } from '@/Utils/Date'
import { format } from 'date-fns'

const props = defineProps({
  events: {
    type: Array,
    default: () => [],
    required: true
  },
})

const currentSlide = ref()

const next = () => {
  if (currentSlide.value < props.events.length - 1) {
    currentSlide.value++
  } else {
    currentSlide.value = 0
  }
}

const prev = () => {
  if (currentSlide.value > 0) {
    currentSlide.value--
  } else {
    currentSlide.value = props.events.length - 1
  }
}

const getEventShow = (event) => {
  router.visit(route('event.show', event.alias), {
    method: 'get',
    preserveState: false,
    preserveScroll: true,
    onSuccess: (result) => {
      console.log(result)
    }
  })
}

</script>

<template>
  <div class="w-full">
    <SwiperWrapper
      loop="true"
      slides-per-view="1"
      :model-value="events"
      watch-slides-progress="true"
      scrollbar="true"
      autoplay-delay="2500"
      slide-class="mb-4"
      @oninit="console.log('hoge')">
      <template #item="{element}">
        <div class="carousel__item w-full px-2">
          <div class="flex flex-col items-center justify-center gap-4 lg:flex-row">
            <CardEventImages class="w-2/6" :images="element.files" />
            <div class="flex w-4/6 flex-col items-start gap-2">
              <div class="flex w-full flex-row justify-between">
                <div> {{ format(new Date(element.start_date), 'yyyy/MM/dd HH:mm') }}</div>
                <div class="flex gap-1">
                  <BtnSwapEventBookmark :event-id="element.alias" :check="element.auth_user?.is_bookmark" />
                  <BtnSwapEventGood
                    :event-id="element.alias" :check="element.auth_user?.is_good" :count="element.short_good_count"
                    show-count />
                </div>
              </div>

              <h1 class="text-5xl font-bold">
                {{ element.title }}
              </h1>
              <!-- category -->
              <div class="flex items-center gap-1 ">
                <IconTypeMapper type="category" class="text-xl" />
                <template v-for="category in element.category_names" :key="category">
                  <BtnEventSearchItem :value="category" type="category" is-navigate />
                </template>
              </div>
              <!-- tag -->
              <div class="flex flex-row items-center gap-1">
                <div class="mr-auto flex items-center gap-1  rounded-md">
                  <IconTypeMapper type="tag" class="text-xl" />
                  <template v-for="tag in element.tags" :key="tag">
                    <BtnEventSearchItem :value="tag" type="tag" is-navigate />
                  </template>
                </div>
              </div>
              <!-- organizers -->
              <div class="flex w-full flex-col justify-center gap-1">
                <div class="flex flex-row items-center gap-1">
                  <IconTypeMapper type="organizer" class="text-md" />
                  <div>organizers</div>
                </div>
                <div class="flex flex-wrap  gap-1 rounded-xl ">
                  <AvatarLink
                    v-for="(organizer, index ) in element.organizers" :key="index" :href="organizer.profile_url"
                    :image-url="organizer.image_url" :name="organizer.name" />
                </div>
              </div>
              <!-- performers -->
              <div class="flex flex-col justify-center gap-1">
                <div class="flex flex-row items-center gap-1">
                  <IconTypeMapper type="performer" class="text-md" />
                  <div>performers</div>
                </div>
                <div class="flex w-full flex-wrap gap-1 rounded-xl ">
                  <AvatarLink
                    v-for="(performer, index ) in element.performers"
                    :key="index" size="size-16" :href="performer.profile_url"
                    :image-url="performer.image_url" :name="performer.name" />
                </div>
              </div>
              <button class=" btn btn-ghost btn-outline btn-sm w-full" @click="getEventShow(event)">
                show more!
              </button>
            </div>
          </div>
        </div>
      </template>
    </SwiperWrapper>
  </div>
</template>

