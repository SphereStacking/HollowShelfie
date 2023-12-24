<script setup>

const props = defineProps({
  event: {
    type: String,
    required: true
  },

  recommendEvents: {
    type: Array,
    default: () => []
  },
  trendTags: {
    type: Array,
    default: () => []
  }
})
defineEmits(
  ['click']
)
//データ整形
const time_table = props.event.time_table
const tags = props.event.tags
const event = props.event
const organizers = props.event.organizers
const instances = props.event.instances

import file1 from '@/Components/LXIX_Design_224-4.png'
import file2 from '@/Components/LXIX_Design_225-5.png'
import file3 from '@/Components/LXIX_Design_196-4.png'
import IconTypeMapper from '@/Components/IconTypeMapper.vue';

const image_flyers = [
  file1,
  file2,
  file3,
]
</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight">
        イベント詳細
      </h2>
    </template>
    <div class="grid lg:grid-cols-12 lg:gap-2 gap-4 auto-rows-min mx-auto max-w-7xl pt-4">
      <!-- header -->
      <div class="lg:col-start-1 lg:col-end-10">
        <div class="flex items-center flex-row ">
          <div class="relative w-5">
            <p class="absolute text-2xl font-normal -rotate-90 grow-0 w-4 ">{{ event.formatted_start_date.year }}</p>
          </div>
          <div class="flex flex-col items-center justify-center pl-1 mr-2 border-l-2 border-base-content">
            <div class="text-3xl font-normal">{{ event.formatted_start_date.month }}</div>
            <div class="text-3xl font-normal">{{ event.formatted_start_date.day }}</div>
          </div>
          <div class="flex flex-col grow ">
            <div class=" prose lg:prose-xl ">
              <h1> {{ event.title }}</h1>
            </div>
            <div class="flex flex-row justify-between items-center">
              <div class="flex flex-row gap-2 items-center">
                <div class="text-xs font-light ">
                  [{{ event.formatted_start_date.weekday }}] {{ event.formatted_start_date.time }}
                  -{{ event.formatted_end_date.time }}
                </div>
                <BadgeEventStatus class="rounded-md lg:row-start-2 lg:col-start-1" :status='event.status'
                  :label='event.status_label'>
                </BadgeEventStatus>
              </div>
              <div class="flex gap-2 p-1 rounded-md items-center">
                <BtnSwapBookmark @click="toggleBookmark" :check="event.auth_user.is_bookmark"></BtnSwapBookmark>
                <BtnSwapGood @click="toggleGood" :check="event.auth_user.is_good" :count="event.short_good_count"
                  showCount>
                </BtnSwapGood>
                <Icon icon="mdi:share-variant" class="text-xl" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class=" flex flex-row gap-1 lg:col-span-7 w-full mx-auto lg:row-start-2 lg:col-start-1">
        <div class="flex gap-1 items-center ">
          <IconTypeMapper type="category" class="text-xl"></IconTypeMapper>
          <BtnEventSerchItem :value="event.category_name" type="category" isNavigate></BtnEventSerchItem>
        </div>
        <div class="flex flex-row gap-1 items-center">
          <div class="flex gap-1 rounded-md items-center  mr-auto">
            <IconTypeMapper type="tag" class="text-xl"></IconTypeMapper>
            <template v-for="(tag, index) in event.tags" :key="index">
              <BtnEventSerchItem :value="tag" type="tag" isNavigate></BtnEventSerchItem>
            </template>
          </div>
        </div>
      </div>
      <!-- header -->
      <!-- leftside -->
      <div class="lg:col-span-3 w-full mx-auto lg:row-start-3">
        <CarouselGallery class="sticky top-12" :images=image_flyers>
        </CarouselGallery>
      </div>
      <!-- leftside -->
      <!-- Main -->
      <div class="lg:col-span-6 w-full mx-auto flex flex-col gap-2">
        <CardArticle>
          <template #content>
            <div class=" prose lg:prose-xl">
              {{ event.description }}
              <!-- {{ props.event }} -->
            </div>
          </template>
        </CardArticle>
        <div class="flex flex-col justify-center  w-full">
          <div class="flex flex-row gap-1 items-center">
            <Icon icon="mdi:ghost" class="text-md"></Icon>
            <div>organizers</div>
          </div>
          <div class="flex rounded-xl bg-base-200 w-full p-2 justify-around">
            <a v-for="(organizer, index ) in organizers" :href='organizer.profile_url'
              class="avatar tooltip h-10 transition-all duration-200 hover:-translate-y-1" :data-tip="organizer.name">
              <img :src="organizer.imag_url" />
            </a>
          </div>
        </div>

        <div class="flex flex-col justify-center w-full">
          <div class="flex flex-row gap-1 items-center">
            <Icon icon="mdi:food" class="text-md"></Icon>
            <div>performers</div>
          </div>
          <div class="flex rounded-xl bg-base-200 w-full p-2 justify-around">
            <a v-for="(organizer, index ) in organizers" :href='organizer.profile_url'
              class="avatar tooltip h-10 transition-all duration-200 hover:-translate-y-1" :data-tip="organizer.name">
              <img :src="organizer.imag_url" />
            </a>
          </div>
        </div>
        <div class="flex flex-col justify-center  w-full">
          <div class="flex flex-row gap-1 items-center">
            <Icon icon="line-md:map-marker-multiple-alt-filled" class="text-md"></Icon>
            <div>location</div>
          </div>
          <div class="flex flex-col rounded-xl bg-base-200 w-full">
            <a v-for="(instance, index ) in instances" href="#"
              class="mx-2 my-1 transition-all duration-200 hover:-translate-y-1 flex flex-row gap-2">
              <div class="badge badge-primary">{{ instance.instance_type }}</div>
              <div class="whitespace-nowrap overflow-hidden"> {{ instance.location }}</div>
            </a>
          </div>
        </div>
      </div>
      <!-- Main -->
      <!-- RightSide -->
      <div class="lg:col-start-10 lg:col-end-13 lg:row-start-1 lg:row-span-2 ">
        <Card class="w-full bg-transparent border h-full">
          <template #title>
            <h4 class="font-bold uppercase ">ここに広告を表示したい</h4>
          </template>
        </Card>
      </div>
      <div class="lg:col-start-10 lg:col-end-13  w-full mx-auto  lg:row-span-3 lg:row-start-3">
        <aside class="sticky top-12" aria-labelledby="sidebar-right">
          <div class="sticky top-36 flex-col  flex gap-4">
            <!-- 人気のタグ -->
            <Card class="w-full">
              <template #title>
                <h4 class="font-bold uppercase ">人気のタグ</h4>
              </template>
              <div class="flex flex-wrap gap-0.5">
                <LinkBadges :route="route('event.search.index')" :tags="trendTags"></LinkBadges>
              </div>
            </Card>
            <!-- 関連記事 -->
            <Card class="w-full">
              <template #title>
                関連イベント
              </template>
              <template #content>
                <div v-for="event in recommendEvents">
                  {{ event.title }}
                </div>
              </template>
            </Card>
            <!-- コミュニティスポンサー -->
            <Card class="w-full">
              <template #title>
                スポンサー
              </template>
              <p>誰もいないよ😿</p>
              <p>まってるよ！</p>
            </Card>
          </div>
        </aside>
      </div>
      <!-- RightSide -->
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
