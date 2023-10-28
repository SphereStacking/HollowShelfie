
<script setup>
import { v4 as uuidv4 } from 'uuid';
import { useForm ,Link,router } from '@inertiajs/vue3';

const props =defineProps({
  event: {
    type: Object,
    required: true
  },
})
const isGoodform = useForm({
  is_good: false,
});
const isLikeform = useForm({
  is_like: false,
});
const item = reactive({
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
  start_time:props.event.start_time ?? 'hh:mm',
  end_time:props.event.end_time ?? 'hh:mm',
  tags: props.event.tags ?? ['hoge', 'fuga']
});

const serchTag = (tagName)=>{
  router.get(route('event.list.index'), {tags: [tagName]}, { replace: true, preserveState: true })
}

// props.eventの変更を監視し、値が変化した場合のみeventにコピー
watch(() => props.event, (newEvent, oldEvent) => {
  for (const key in newEvent) {
    if (item.hasOwnProperty(key) && newEvent[key] !== oldEvent[key]) {
      item[key] = newEvent[key];
    }
  }
}, { deep: true });


const state = reactive({
  goodRotated: false,
})
import file1 from './picture1.png'
import file2 from './picture2.png'
import file3 from './picture3.png'
import file4 from './picture4.png'
const image_flyers =[
  file1,
  file2,
  file3,
  file4,
]

const getPrevIndex = (index) => {
  return index == 0? image_flyers.length-1 : index-1
}
const getNextIndex = (index) => {
  return index == image_flyers.length-1? 0 : index+1
}
const toggleLike = ()=>{
  console.log('hogeeeee');
  form.post(route('event.like.toggle',item.id)), {
    preserveScroll:true,
    onSuccess: (data) => {
      console.log('fugggaaa');
      console.log(data);
    },
  };
}

const toggleGood = ()=>{
  state.goodRotated = true
  form.post(route('event.good.toggle',item.id)), {
    preserveScroll: true,
    onSuccess: () => {
    },
    onFinish:()=>{
      setTimeout(() => {
        state.goodRotated = false
      }, 100)
    }
  };
}
</script>

<template>
  <div class="carousel w-full">
    <template v-for="(image ,index) in image_flyers" :key="index">
      <div :id="'item'+item.id+index" class="carousel-item relative w-full">
        <img :src="image" class="w-full">
        <div class="absolute inset-x-0 top-1/2 flex h-full -translate-y-1/2 justify-between">
          <a :href="'#item'+item.id+ getPrevIndex(index)" class="h-full w-full "></a>
          <a :href="'#item'+item.id+ getNextIndex(index)" class="h-full w-full "></a>
        </div>
      </div>
    </template>
  </div>
  <div class="card card-compact bg-base-100 shadow-xl">

    <div  class="flex flex-row mt-0.5">
        <a v-for="(image ,index) in image_flyers" :key="index"
        :href="'#item'+item.id+ getPrevIndex(index)" class="h-3 w-full mx-1 rounded-lg bg-lime-300"></a>
    </div>
    <div class="flex w-full justify-between gap-2 pt-2">
      <div class="ml-2 flex  justify-start gap-2">
        <div class="badge gap-2" :class="{
          'badge-neutral' : item.status=='draft',
          'badge-error' : item.status=='canceled',
          'badge-neutral' : item.status=='published',
          'badge-success' : item.status=='ongoing',
          'badge-error' : item.status=='deleted',
          'badge-info' : item.status=='closed',
        }">
          {{ item.status_labl }}
        </div>

      </div>

      <div class="mr-2 flex justify-end gap-2">
        <div>
          <Icon
            v-if="item.is_good" icon="material-symbols:thumb-up-rounded"
            class="rotate-0  text-xl text-pink-400 transition duration-200"
            :class="{ '-rotate-90': state.goodRotated }"
            @click="toggleGood" />
          <Icon
            v-if="!item.is_good" icon="material-symbols:thumb-up-outline-rounded" class="text-xl"
            @click="toggleGood" />
        </div>
        <div>
          <Icon
            v-if="!item.is_like" icon="line-md:heart" class="text-xl"
            @click="toggleLike" />
          <Icon
            v-if="item.is_like" icon="line-md:heart-filled" class="text-xl text-pink-400"
            @click="toggleLike" />
        </div>
        <div>
          <Icon icon="material-symbols:share" class="text-xl" />
        </div>
      </div>
    </div>

    <div class="card-body ">

      <h2 class="card-title h-20">
        {{ item.title }}
      </h2>
      <div class="flex flex-wrap">
        <div v-for="name in item.tags" :key="tag" @click="serchTag(name)" class="badge badge-ghost badge-md mr-1 hover:badge-outline">
          {{ name }}
        </div>
      </div>
      <div clas="flex flex-col">
        <div class="flex flex-row gap-1">
          <Icon icon="line-md:calendar" class=" text-xl" />
          <CalendarEventCreate>
            <BtnLink> {{ item.formatted_date_time }}</BtnLink>
          </CalendarEventCreate>
        </div>

        <div class="flex flex-row gap-1">
          <Icon icon="line-md:map-marker" class="text-xl w-8" />
          <p class="truncate whitespace-nowrap">
            {{ item.location }}
          </p>
        </div>


        <div class="flex flex-row justify-between">
        <div class="flex flex-row gap-1">
          <Icon icon="line-md:account" class="text-xl" />
          <Link :href="route('organizer.show',item.organizer_id)" class="btn btn-link btn-active btn-xs px-0">{{event.organizer}}</Link>
        </div>
        <Link :href="route('event.show',item.id)" class="btn btn-link btn-active btn-xs px-0">Read more➡</Link>
      </div>
    </div>
  </div>
</div>

</template>

<style lang="">

</style>
