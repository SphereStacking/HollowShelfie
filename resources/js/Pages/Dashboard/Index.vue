<script setup>
import { Link } from '@inertiajs/vue3'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
const props = defineProps({
  auth: {
    type: Object,
    required: true,
  },
  counts: {
    type: Object,
    default: () => ({}),
  },
})

const dashboardCategory = [
  { id: 'activity', iconType: 'activity', title: 'アクティビティ' },
  { id: 'search', iconType: 'search', title: '探索！' },
  { id: 'socialInteraction', iconType: 'socialInteraction', title: 'Social interaction' },
  { id: 'team', iconType: 'team', title: 'Team' },
  { id: 'organize', iconType: 'organize', title: 'Organize' },
  { id: 'setting', iconType: 'setting', title: 'Setting' },
]
const dashboardItems = [
  { category: 'activity', iconType: 'bookmarks', title: 'bookmarks', url: route('user.bookmark', props.auth.user.screen_name), buttonText: props.counts.bookmark?.total || 0 },
  { category: 'activity', iconType: 'onGood', title: 'Goods', url: route('user.good', props.auth.user.screen_name), buttonText: props.counts.good || 0 },
  { category: 'search', iconType: 'event', title: 'イベントを探す', url: route('event.search.index'), buttonText: 'go' },
  { category: 'search', iconType: 'team', title: 'チームを探す(仮)', url: '#', buttonText: 'go' },
  { category: 'search', iconType: 'user', title: 'ユーザーを探す(仮)', url: '#', buttonText: 'go' },
  { category: 'search', iconType: 'recruiting', title: '募集を探す(仮)', url: route('event.recruiting'), buttonText: 'go' },
  { category: 'socialInteraction', iconType: 'follow', title: 'フォロー', url: route('user.following', props.auth.user.screen_name), buttonText: props.counts.follow || 0 },
  { category: 'socialInteraction', iconType: 'follower', title: 'フォロワー', url: route('user.follower', props.auth.user.screen_name), buttonText: props.counts.follower || 0 },
  { category: 'team', iconType: 'teamCreate', title: 'チームを作成する', url: route('teams.create'), buttonText: 'go!' },
  { category: 'team', iconType: 'team', title: '所属チーム(仮)', url: '#', buttonText: 'go' },
  { category: 'organize', iconType: 'event', title: 'イベントを主催する(仮)', url: route('event.create'), buttonText: 'go' },
  { category: 'organize', iconType: 'myEvents', title: 'イベント管理(仮)', url: route('event.manage'), buttonText: '表示' },
  { category: 'setting', iconType: 'account', title: 'アカウント設定', url: route('profile.show'), buttonText: 'go' },
  { category: 'setting', iconType: 'profile', title: '公開プロファイル', url: props.auth.user.profile_url, buttonText: 'go' },
]
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        ダッシュボード
      </h2>
    </template>

    <div class="mx-auto grid w-full max-w-7xl grid-cols-2  gap-5 sm:grid-cols-3  md:grid-cols-4 xl:grid-cols-6">
      <template v-for="category in dashboardCategory" :key="category.id">
        <div class="divider divider-start col-span-full mt-10 text-xl  font-semibold">
          <IconTypeMapper :type="category.iconType" class="text-2xl" />
          {{ category.title }}
        </div>
        <template v-for="item in dashboardItems" :key="item.title">
          <div
            v-if="item.category === category.id"
            class="col-span-2">
            <Card>
              <template #title>
                <div class="flex w-full items-center justify-between">
                  <div class="flex items-center gap-0.5">
                    <IconTypeMapper :type="item.iconType" />
                    {{ item.title }}
                  </div>
                  <Link class="btn btn-primary btn-sm w-20" :href="item.url">
                    {{ item.buttonText }}
                  </Link>
                </div>
              </template>
            </Card>
          </div>
        </template>
      </template>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>

