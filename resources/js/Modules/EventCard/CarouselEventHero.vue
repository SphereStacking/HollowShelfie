<script setup>
import { format } from 'date-fns'
import { Link } from '@inertiajs/vue3'

defineProps({
  events: {
    type: Array,
    default: () => [],
    required: true
  },
})

</script>

<template>
  <div class="w-full">
    <SwiperWrapper
      :loop="events.length > 1"
      :slides-per-view="1"
      :model-value="events"
      watch-slides-progress="true"
      :scrollbar="true"
      :autoplay-delay="5000"
      slide-class="mb-4">
      <template #item="{element}">
        <div class="w-full  px-2">
          <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
            <CardEventImages class="w-full sm:w-2/6" :url="route('event.show', element.alias)" :images="element.files" />
            <div class="flex w-full flex-col items-start gap-2 overflow-hidden sm:w-4/6">
              <div class="flex w-full flex-row justify-between">
                <div> {{ format(new Date(element.start_date), 'yyyy/MM/dd HH:mm') }}</div>
                <div class="flex gap-1">
                  <BtnSwapEventBookmark :event-id="element.alias" :check="element.auth_user?.is_bookmark" />
                  <BtnSwapEventGood
                    :event-id="element.alias" :check="element.auth_user?.is_good" :count="element.short_good_count"
                    show-count />
                </div>
              </div>
              <h2>
                <Link
                  :href="route('event.show', element.alias)"
                  class="break-words text-5xl font-bold transition-all duration-200 hover:text-accent hover:underline lg:text-6xl">
                  {{ element.title }}
                </Link>
              </h2>
              <!-- category -->
              <div v-if="element.category_names.length > 0" class="flex flex-row items-start gap-1">
                <IconTypeMapper type="category" class="mt-0.5 shrink-0 text-xl" />
                <div class="flex flex-wrap gap-1">
                  <BtnEventSearchItem
                    v-for="category in element.category_names" :key="category" :value="category"
                    type="category" is-navigate />
                </div>
              </div>
              <!-- tag -->
              <div v-if="element.tags.length > 0" class="flex flex-row items-start gap-1">
                <IconTypeMapper type="tag" class="mt-0.5 shrink-0 text-xl" />
                <div class="flex flex-wrap gap-1">
                  <BtnEventSearchItem
                    v-for="tag in element.tags" :key="tag" :value="tag"
                    type="tag" is-navigate />
                </div>
              </div>
              <!-- organizers -->
              <div v-if="element.organizers.length > 0" class="flex w-full flex-col justify-start gap-1">
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
              <div v-if="element.performers.length > 0" class="flex flex-col justify-center gap-1">
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
            </div>
          </div>
        </div>
      </template>
    </SwiperWrapper>
  </div>
</template>

