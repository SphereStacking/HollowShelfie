<script setup>
const Roadmap = [
  {
    title: '1.0',
    status: 'done',
    features: [
      { status: 'done', feature: 'イベント掲載機能'},
      { status: 'done', feature: 'イベント検索機能'},
      { status: 'done', feature: 'タグ付け機能'},
      { status: 'done', feature: 'カテゴリ付け機能'},
      { status: 'done', feature: 'フォロー機能'},
      { status: 'done', feature: 'ブックマーク機能'},
    ]
  },
  {
    title: '2.0',
    status: 'doing',
    features: [
      { status: 'experiment', feature: 'チーム機能'},
      { status: 'doing', feature: '通知機能'},
      { status: 'plan', feature: 'ユーザー検索'}
    ]
  },
  {
    title: 'planning',
    status: 'plan',
    features: [
      { status: 'plan', feature: 'バナー掲載'},
      { status: 'plan', feature: '主催者-演者マッチング'},
      { status: 'plan', feature: 'チケット機能'},
      { status: 'plan', feature: 'カスタムプロフィール'}
    ]
  }
]

const status = {
  'done': {icon: 'mdi:rocket-launch', iconClass: 'text-success', hrClass: 'bg-success/40'},
  'experiment': {icon: 'mdi:flask', iconClass: 'text-info', hrClass: 'bg-neutral/40'},
  'doing': {icon: 'mdi:spanner', iconClass: 'text-warning', hrClass: 'bg-neutral/40'},
  'plan': {icon: 'mdi:access-time', iconClass: 'text-base-content/60', hrClass: 'bg-neutral/40'},
}

</script>
<template>
  <AppLayout title="Roadmap">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight">
        Roadmap
      </h2>
    </template>

    <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
      <div class=" rounded-box bg-base-200 pe-10 ps-6 pt-10 shadow-2xl lg:py-16 lg:pe-16 lg:ps-6">
        <ul class="timeline timeline-vertical timeline-compact timeline-snap-icon mb-20">
          <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold">
              HollowShelfie
            </h1>
            <p class="mt-2 text-lg">
              ロードマップ、マイルストーン、今後の実装予定機能
            </p>
          </div>
          <li v-for="(item, index) in Roadmap" :key="item.title" class="lg:gap-x-6">
            <div class="timeline-middle">
              <div class="mb-2 rounded-full  bg-neutral p-2">
                <icon :icon="status[item.status].icon" :class="status[item.status].iconClass" class=" text-xl" />
              </div>
            </div>
            <div class="timeline-end timeline-box mb-4 w-full p-4 lg:mb-10 lg:p-10">
              <h2 class="mb-6 text-2xl font-black">
                {{ item.title }}
              </h2>
              <ol>
                <template v-for="feature in item.features" :key="feature.feature">
                  <li class="my-2 mt-1.5 flex items-center gap-2">
                    <icon :icon="status[feature.status].icon" :class="status[feature.status].iconClass" class="text-xl" />
                    <span class="text-lg text-base-content/60">{{ feature.feature }}</span>
                  </li>
                </template>
              </ol>
            </div>
            <hr v-if="index !== Roadmap.length - 1" :class="status[item.status].hrClass">
          </li>
        </ul>
      </div>
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
