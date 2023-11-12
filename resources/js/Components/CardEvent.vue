
<script setup>
import { v4 as uuidv4 } from 'uuid';
import { useForm, Link, router } from '@inertiajs/vue3';
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

const props = defineProps({
  event: {
    type: Object,
    required: true
  },
})
const form = useForm({
  is_bookmark: false,
  is_good: false,
});

const state = reactive({
  goodRotated: false,
})
import file1 from './LXIX_Design_224-4.png'
import file2 from './LXIX_Design_225-5.png'
import file3 from './LXIX_Design_196-4.png'
import { previousTuesday } from 'date-fns';

const image_flyers = [
  file1,
  file2,
  file3,
]

const toggleBookmark = () => {
  form.post(route('event.bookmark.toggle', props.event.id)), {
    preserveScroll: true,
    onSuccess: (data) => {
      console.log(data);
    },
  };
}

const toggleGood = () => {
  state.goodRotated = true
  form.post(route('event.good.toggle', props.event.id)), {
    preserveScroll: true,
    onSuccess: () => {
    },
    onFinish: () => {
      setTimeout(() => {
        state.goodRotated = false
      }, 100)
    }
  };
}

</script>

<template>
  <div class="card card-compact bg-neutral shadow-xl">
    <div class="flex justify-between mt-2 mx-2">
      <div>
        <badgeEventStatus :status='event.status' :label='event.status_label'>
        </badgeEventStatus>
      </div>
      <div class="mr-2 flex justify-end gap-2">
        <div>
          <Icon v-if="event.auth_user.is_good" icon="material-symbols:thumb-up-rounded"
            class="rotate-0  text-xl text-pink-400 transition duration-200" :class="{ '-rotate-90': state.goodRotated }"
            @click="toggleGood" />
          <Icon v-if="!event.auth_user.is_good" icon="material-symbols:thumb-up-outline-rounded" class="text-xl"
            @click="toggleGood" />
        </div>
        <div>
          <Icon v-if="!event.auth_user.is_bookmark" icon="line-md:clipboard-check-to-clipboard-transition" class="text-xl"
            @click="toggleBookmark" />
          <Icon v-if="event.auth_user.is_bookmark" icon="line-md:clipboard-check-twotone" class="text-xl text-pink-400"
            @click="toggleBookmark" />
        </div>
        <DropDownSnsShare>
          <Icon icon="material-symbols:share" class="text-xl" />
        </DropDownSnsShare>
      </div>
    </div>
    <div class="flex justify-between mt-1 mx-2">
      <div class="w-20">{{ event.category_name }}</div>
      <div>{{ event.title }}</div>
    </div>
    <Carousel :autoplay="5000" :wrap-around="true" class="flex flex-col" pauseAutoplayOnHover>
      <Slide v-for="(image, index) in image_flyers" :key="index">
        <img class="carousel__item" :src="image">
      </Slide>

      <template #addons>
        <Pagination />
      </template>
    </Carousel>
    <div class="flex flex-row  justify-around mb-2">
      <Icon icon="line-md:map-marker" class="text-xl w-8" />
      <Icon icon="line-md:calendar" class=" text-xl" />
      <Icon icon="line-md:account" class="text-xl" />
      <Link :href="route('event.show', event.id)" class="btn btn-link btn-active btn-xs px-0">Read more➡</Link>
    </div>
  </div>
</template>

<style lang="">

</style>
