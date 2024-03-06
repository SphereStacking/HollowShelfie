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
const performers = props.event.performers

const instances = props.event.instances

import IconTypeMapper from '@/Components/IconTypeMapper.vue'

</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight">
        イベント詳細
      </h2>
    </template>
    <div class="mx-auto grid max-w-7xl auto-rows-min gap-4 pt-4 lg:grid-cols-12 lg:gap-2">
      <!-- header -->
      <div class="lg:col-start-1 lg:col-end-10">
        <div class="flex flex-row items-center ">
          <div class="relative w-5">
            <p class="absolute w-4 grow-0 -rotate-90 text-2xl font-normal ">
              {{ event.formatted_start_date.year }}
            </p>
          </div>
          <div class="mr-2 flex flex-col items-center justify-center border-l-2 border-base-content pl-1">
            <div class="text-3xl font-normal">
              {{ event.formatted_start_date.month }}
            </div>
            <div class="text-3xl font-normal">
              {{ event.formatted_start_date.day }}
            </div>
          </div>
          <div class="flex grow flex-col ">
            <div class=" prose lg:prose-xl ">
              <h1> {{ event.title }}</h1>
            </div>
            <div class="flex flex-row items-center justify-between">
              <div class="flex flex-row items-center gap-2">
                <div class="text-xs font-light ">
                  [{{ event.formatted_start_date.weekday }}] {{ event.formatted_start_date.time }}
                  -{{ event.formatted_end_date.time }}
                </div>
                <BadgeEventStatus
                  class="rounded-md lg:col-start-1 lg:row-start-2" :status="event.status"
                  :label="event.status_label" />
              </div>
              <div class="flex items-center gap-2 rounded-md p-1">
                <BtnSwapEventBookmark :event-id="event.id" :check="event.auth_user?.is_bookmark" />
                <BtnSwapEventGood
                  :event-id="event.id" :check="event.auth_user?.is_good" :count="event.short_good_count"
                  show-count />
                <Icon icon="mdi:share-variant" class="text-xl" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class=" mx-auto flex w-full flex-row gap-1 lg:col-span-7 lg:col-start-1 lg:row-start-2">
        <div class="flex flex-row items-center gap-1">
          <div class="mr-auto flex items-center gap-1  rounded-md">
            <IconTypeMapper type="category" class="text-xl" />
            <template v-for="(category_name, index) in event.category_names" :key="index">
              <BtnConditionTypeMapper type="category" class="no-animation">
                {{ category_name }}
              </BtnConditionTypeMapper>
            </template>
          </div>
        </div>
        <div class="flex flex-row items-center gap-1">
          <div class="mr-auto flex items-center gap-1  rounded-md">
            <IconTypeMapper type="tag" class="text-xl" />
            <template v-for="(tag, index) in event.tags" :key="index">
              <BtnEventSerchItem :value="tag" type="tag" is-navigate />
            </template>
          </div>
        </div>
      </div>
      <!-- header -->
      <!-- leftside -->
      <div class="mx-auto w-full lg:col-span-3 lg:row-start-3">
        <Card>
          <CarouselGallery class="sticky top-12" :images="event.files" />
        </Card>
      </div>
      <!-- leftside -->
      <!-- Main -->
      <div class="mx-auto flex w-full flex-col gap-2 lg:col-span-6">
        <CardArticle>
          <template #content>
            <div class=" prose lg:prose-xl">
              {{ event.description }}
              <!-- {{ props.event }} -->
            </div>
          </template>
        </CardArticle>
        <div class="flex w-full flex-col  justify-center">
          <div class="flex flex-row items-center gap-1">
            <Icon icon="mdi:ghost" class="text-md" />
            <div>organizers</div>
          </div>
          <div class="flex w-full justify-around rounded-xl bg-base-200 p-2">
            <a
              v-for="(organizer, index ) in organizers" :key="index" :href="organizer.profile_url"
              class="avatar tooltip h-10 transition-all duration-200 hover:-translate-y-1" :data-tip="organizer.name">
              <img :src="organizer.imag_url">
            </a>
          </div>
        </div>

        <div class="flex w-full flex-col justify-center">
          <div class="flex flex-row items-center gap-1">
            <Icon icon="mdi:food" class="text-md" />
            <div>performers</div>
          </div>
          <div class="flex w-full justify-around rounded-xl bg-base-200 p-2">
            <a
              v-for="(performer, index ) in performers" :key="index" :href="performer.profile_url"
              class="avatar tooltip h-10 transition-all duration-200 hover:-translate-y-1" :data-tip="performer.name">
              <img :src="performer.image_url">
            </a>
          </div>
        </div>
        <div class="flex w-full flex-col  justify-center">
          <div class="flex flex-row items-center gap-1">
            <Icon icon="line-md:map-marker-multiple-alt-filled" class="text-md" />
            <div>location</div>
          </div>
          <div class="flex w-full flex-col rounded-xl bg-base-200">
            <a
              v-for="(instance, index ) in instances" :key="index" href="#"
              class="mx-2 my-1 flex flex-row gap-2 transition-all duration-200 hover:-translate-y-1">
              <div class="badge badge-primary">{{ instance.instance_type }}</div>
              <div class="overflow-hidden whitespace-nowrap"> {{ instance.location }}</div>
            </a>
          </div>
        </div>
      </div>
      <!-- Main -->
      <!-- RightSide -->
      <div class="lg:col-start-10 lg:col-end-13 lg:row-span-2 lg:row-start-1 ">
        <Card class="h-full w-full border bg-transparent">
          <template #title>
            <h4 class="font-bold uppercase ">
              ここに広告を表示したい
            </h4>
          </template>
        </Card>
      </div>
      <div class="mx-auto w-full  lg:col-start-10 lg:col-end-13  lg:row-span-3 lg:row-start-3">
        <aside class="sticky top-12" aria-labelledby="sidebar-right">
          <div class="sticky top-36 flex  flex-col gap-4">
            <!-- 人気のタグ -->
            <Card class="w-full">
              <template #title>
                <h4 class="font-bold uppercase ">
                  人気のタグ
                </h4>
              </template>
              <div class="flex flex-wrap gap-0.5">
                <LinkBadges :route="route('event.search.index')" :tags="trendTags" />
              </div>
            </Card>
            <!-- 関連記事 -->
            <Card class="w-full">
              <template #title>
                関連イベント
              </template>
              <template #content>
                <div v-for="event in recommendEvents" :key="event.id">
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
