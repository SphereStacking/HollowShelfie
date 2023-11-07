
<script setup>
import { v4 as uuidv4 } from 'uuid';
import { useForm, Link, router } from '@inertiajs/vue3';

const props = defineProps({
  event: {
    type: Object,
    required: true
  },
})
const isGoodform = useForm({
  is_like: false,
  is_good: false,
});
const isLikeform = useForm({
  is_like: false,
});
const event = reactive({
  id: props.event.id ?? '',
  organizer: props.event.organizer ?? 'hoge',
  organizer_id: props.event.organizer_id ?? 1,
  location: props.event.location ?? 'すふぃあの家',
  title: props.event.title ?? 'ほぉおおぉぉおおげ',
  status: props.event.status ?? 'piyo',
  status_labl: props.event.status_labl ?? 'ぴよ',
  is_like: props.event.is_like ?? false,
  is_good: props.event.is_good ?? false,
  formatted_date_time: props.event.formatted_date_time ?? 'hoge年fu月ga日',
  start_time: props.event.start_time ?? 'hh:mm',
  end_time: props.event.end_time ?? 'hh:mm',
  tags: props.event.tags ?? ['hoge', 'fuga']
});

// props.eventの変更を監視し、値が変化した場合のみeventにコピー
watch(() => props.event, (newEvent, oldEvent) => {
  for (const key in newEvent) {
    if (event.hasOwnProperty(key) && newEvent[key] !== oldEvent[key]) {
      event[key] = newEvent[key];
    }
  }
}, { deep: true });


const state = reactive({
  goodRotated: false,
})
import file1 from './LXIX_Design_224-4.png'
import file2 from './LXIX_Design_225-5.png'
import file3 from './LXIX_Design_196-4.png'

const image_flyers = [
  file1,
  file2,
  file3,
]

const getPrevIndex = (index) => {
  return index == 0 ? image_flyers.length - 1 : index - 1
}
const getNextIndex = (index) => {
  return index == image_flyers.length - 1 ? 0 : index + 1
}
const toggleLike = () => {
  console.log('hogeeeee');
  form.post(route('event.like.toggle', { event: event.id })), {
    preserveScroll: true,
    onSuccess: (data) => {
      console.log('fugggaaa');
      console.log(data);
    },
  };
}

const toggleGood = () => {
  state.goodRotated = true
  form.put(route('teams.update', props.team), {
    errorBag: 'updateTeamName',
    preserveScroll: true,
  });
  form.post(route('event.good.toggle', { event: event.id })), {
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
  <div class="card card-compact bg-base-100 shadow-xl">
    <div class="carousel w-full">
      <template v-for="(image, index) in image_flyers" :key="index">
        <div :id="'item' + event.id + index" class="carousel-item relative w-full">
          <img :src="image" class="w-full">
          <div class="absolute inset-x-0 top-1/2 flex h-full -translate-y-1/2 justify-between">
            <a :href="'#item' + event.id + getPrevIndex(index)" class="h-full w-full "></a>
            <a :href="'#item' + event.id + getNextIndex(index)" class="h-full w-full "></a>
          </div>
        </div>
      </template>
    </div>
    <div class="flex flex-row mt-0.5">
      <a v-for="(image, index) in image_flyers" :key="index" :href="'#item' + event.id + index"
        class="h-3 w-full mx-1 rounded-lg bg-lime-300"></a>
    </div>
    <div class="flex w-full justify-between gap-2 pt-2">
      <div class="ml-2 flex  justify-start gap-2">
        <div class="badge gap-2" :class="{
          'badge-neutral': event.status == 'draft',
          'badge-error': event.status == 'canceled',
          'badge-neutral': event.status == 'published',
          'badge-success': event.status == 'ongoing',
          'badge-error': event.status == 'deleted',
          'badge-info': event.status == 'closed',
        }">
          {{ event.status_labl }}
        </div>

      </div>

      <div class="mr-2 flex justify-end gap-2">
        <div>
          <Icon v-if="event.is_good" icon="material-symbols:thumb-up-rounded"
            class="rotate-0  text-xl text-pink-400 transition duration-200" :class="{ '-rotate-90': state.goodRotated }"
            @click="toggleGood" />
          <Icon v-if="!event.is_good" icon="material-symbols:thumb-up-outline-rounded" class="text-xl"
            @click="toggleGood" />
        </div>
        <div>
          <Icon v-if="!event.is_like" icon="line-md:heart" class="text-xl" @click="toggleLike" />
          <Icon v-if="event.is_like" icon="line-md:heart-filled" class="text-xl text-pink-400" @click="toggleLike" />
        </div>
        <DropDownSnsShare>
          <Icon icon="material-symbols:share" class="text-xl" />
        </DropDownSnsShare>
      </div>
    </div>

    <div class="card-body ">

      <h2 class="card-title h-20">
        {{ event.title }}
      </h2>
      <div class="flex flex-wrap gap-0.5">
        <LinkBadges :route="route('event.list.index')" :tags="event.tags"></LinkBadges>
      </div>
      <div clas="flex flex-col">
        <div class="flex flex-row gap-1">
          <Icon icon="line-md:calendar" class=" text-xl" />
          <CalendarEventCreate title="帆毛" :dates="[]" details="ほげ" location="HOGE">
            <BtnLink> {{ event.formatted_date_time }}</BtnLink>
          </CalendarEventCreate>
        </div>

        <div class="flex flex-row gap-1">
          <Icon icon="line-md:map-marker" class="text-xl w-8" />
          <p class="truncate whitespace-nowrap">
            {{ event.location }}
          </p>
        </div>


        <div class="flex flex-row justify-between">
          <div class="flex flex-row gap-1">
            <Icon icon="line-md:account" class="text-xl" />
            <Link :href="route('organizer.show', event.organizer_id)" class="btn btn-link btn-active btn-xs px-0">
            {{ event.organizer }}</Link>
          </div>
          <Link :href="route('event.show', event.id)" class="btn btn-link btn-active btn-xs px-0">Read more➡</Link>
        </div>
      </div>


    </div>
  </div>
</template>

<style lang="">

</style>
