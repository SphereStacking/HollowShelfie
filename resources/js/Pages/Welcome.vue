<script setup>
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
import AppLayout from '@/Layouts/AppLayout.vue'

import { usePage, Link } from '@inertiajs/vue3'
const page = usePage()
const developer = page.props.developer ?? null
const events = page.props.events ?? []
const eventCount = page.props.eventCount ?? 0
const userCount = page.props.userCount ?? 0
const issueForms = page.props.config.issueForms ?? []
const supportings = page.props.config.supportings ?? []
const feedbacks = page.props.feedbacks ?? []
const sponsors = page.props.sponsors ?? []
// アイコンタイプ、ラベル、説明のデータ構造を定義
const AppStatuses = [
  { type: 'trend', label: 'PV', description: 'サイトへのアクセス数です。', count: 0 },
  { type: 'organizer', label: 'User', description: '登録されているユーザー数です。', count: userCount },
  { type: 'event', label: 'Event', description: '開催予定のイベント数です。', count: eventCount },
]
const features = [
  { icon: 'good', description: '評価' },
  { icon: 'bookmarks', description: 'ブックマーク' },
  { icon: 'event', description: 'イベントの掲載' },
  { icon: 'search', description: 'イベントの検索' },
  { icon: 'follow', description: 'フォロー'},
  { icon: 'timeline', description: 'タイムライン表示', plan: 'free / coming soon', isComingSoon: true },
  { icon: 'team', description: 'チーム', plan: 'standard / coming soon', isComingSoon: true },
  { icon: 'matching', description: '主催者と演者のマッチング', plan: 'standard / coming soon', isComingSoon: true },
  { icon: 'advertisement', description: 'バナー掲載', plan: 'premium / coming soon', isComingSoon: true },
]
const featureBanners = [
  { title: 'イベントをいいねで応援！', description: 'あなたの一つの「いいね」が、イベントの魅力を多くの人へと伝える力になります。イベントページで気に入ったものに「いいね」をして、主催者を応援しましょう。' },
  { title: '行きたいイベントをブックマーク！', description: '「行きたい！」と思ったイベントはブックマーク機能を使って保存しましょう。後で簡単にアクセスできるようになり、あなたの興味に合ったイベントを見逃すことがありません。' },
  { title: '主催するイベント掲載して告知しよう！', description: 'あなたが主催するイベントを当プラットフォームに掲載することで、より多くの参加者と繋がることができます。イベントの詳細情報を入力して、効果的な告知を始めましょう。' },
  { title: '推しのオーガナイザー&パフォーマーをフォローしてイベントを見逃さない！', description: 'お気に入りのオーガナイザーやパフォーマーをフォローすることで、彼らが主催するイベント情報をいち早くキャッチできます。フォロー機能を使って、大切なイベントを見逃すことがないようにしましょう。' }
]
const plans = [
  {
    title: 'Default',
    price: 'Free',
    supplement: '含まれる',
    features: ['基本機能'],
    isComingSoon: false,
    link: { label: '登録', url: '' }
  },
  {
    title: 'Standard',
    price: '500/月',
    supplement: '基本の全てに加えて、',
    features: ['チーム', 'マッチング掲載', '記事投稿', 'カスタムurl'],
    isComingSoon: true,
    link: { label: '', url: '' }
  },
  {
    title: 'Premium',
    price: '1000～/月',
    supplement: 'スタンダードの全てに加えて、',
    features: ['広告掲載', 'バナー掲載件', 'イベントレコメンド', ],
    isComingSoon: true,
    link: { label: '', url: '' }
  },
]
// フィードバックを3つの列に分割する計算プロパティ
const columns = computed(() => {
  return Array.from({ length: 3 }, (_, colIndex) =>
    feedbacks.filter((_, index) => index % 3 === colIndex)
  )
})

</script>

<template>
  <AppLayout>
    <section class="relative mx-auto w-full max-w-screen-lg overflow-x-clip px-5 pt-20">
      <div class="flex flex-col items-center">
        <ApplicationLogo class=" h-24" />
      </div>
      <div class="mt-20 flex flex-row items-center justify-around">
        <div class=" items-center text-2xl font-bold">
          <div>
            新しい出会い、感動、そして冒険。<br>
            あなたの次の体験を、ここから見つけて始めよう。<br>
            <br>
            未知なるイベントの世界へ踏み出そう！
          </div>
        </div>
        <div class="flex flex-col gap-2">
          <Link href="/home" class="btn btn-primary btn-lg ">
            イベントを探す
          </Link>
          <Link href="/home" class="btn btn-link btn-sm ">
            今すぐ登録
          </Link>
        </div>
      </div>
    </section>
    <section class=" flex flex-row items-center justify-around py-32">
      <div v-for="status in AppStatuses" :key="status.type" class="group ">
        <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-base-300 transition-all duration-200 group-hover:bg-accent">
          <IconTypeMapper :type="status.type" class="h-10 w-10 transition-all duration-200 group-hover:text-accent-content" />
        </div>
        <div class="text-center">
          {{ status.label }}
          {{ status.count }}
        </div>
      </div>
    </section>
    <section class="overflow-hidden whitespace-nowrap py-32">
      <div class=" flex animate-slide-infinite flex-row p-5">
        <CardEventCompact
          v-for="event in events" :key="event.id" :event="event"
          class="m-5  w-40" />
        <CardEventCompact
          v-for="event in events" :key="event.id" :event="event"
          class="m-5 w-40" />
      </div>
    </section>
    <section class="relative mx-auto w-full max-w-screen-lg overflow-x-clip px-5 py-32">
      <div class="rounded-md py-10 text-center font-neon text-3xl font-black text-yellow-500-neon">
        Pricing
      </div>
      <div class="grid grid-cols-1 gap-4  md:grid-cols-3 ">
        <div
          v-for="plan in plans" :key="plan"
          class="relative flex flex-col justify-between rounded-lg bg-base-300 p-6 shadow-lg">
          <div v-if="plan.isComingSoon" class="absolute left-0 top-0 h-full w-full rounded-lg bg-base-300/80"></div>
          <div>
            <h3 class="mb-2 text-3xl font-black">
              {{ plan.title }}
            </h3>
            <p class="mb-4 text-lg">
              {{ plan.price }}
            </p>
            <ul class="mb-4">
              <li class="text-lg">
                {{ plan.supplement }}
              </li>
              <li v-for="feature in plan.features" :key="feature" class="text-lg">
                ✅{{ feature }}
              </li>
            </ul>
          </div>
          <a
            href="#" class="btn btn-outline w-full">
            {{ plan.isComingSoon ? 'coming soon...?' : '選択' }}
          </a>
        </div>
      </div>
    </section>
    <section class=" relative mx-auto w-full max-w-screen-lg overflow-x-clip px-5 py-32">
      <TransitionInViewportObserver
        class=" absolute"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class="h-44 w-44  rotate-12 bg-teal-200/10"></div>
      </TransitionInViewportObserver>
      <TransitionInViewportObserver
        class="absolute bottom-2 right-5 h-32 w-32"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="-translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class=" rotate-12 bg-teal-200/10"></div>
      </TransitionInViewportObserver>
      <div class="rounded-3xl border-4 border-teal-300  shadow-xl shadow-teal-500/50 ">
        <div class="rounded-md pt-10 text-center font-neon text-3xl font-black text-teal-500-neon">
          Features
        </div>
        <div class=" grid grid-cols-2 gap-5 p-10 text-base-content md:px-52">
          <TransitionInViewportObserver
            v-for="(feature, index) in features"
            :key="feature"
            enter-active-class="transition-all duration-1000"
            leave-active-class="transition-all duration-1000"
            :enter-from-class="index % 2 === 0 ? '-translate-x-20 opacity-0' : 'translate-x-20 opacity-0'"
            leave-to-class="opacity-0">
            <div
              class="indicator flex  w-full flex-row items-center rounded-md bg-base-200 p-4"
              :class="feature.isComingSoon ? 'bg-base-300/20' : 'bg-base-300'">
              <span v-if="feature.plan" class="badge indicator-item translate-x-2 text-base-content">
                {{ feature.plan }}
              </span>
              <div class="flex flex-row items-center gap-2">
                <IconTypeMapper :type="feature.icon" class="h-10 w-10" />
              </div>
              <div class="ml-4 ">
                <div class="text-2xl font-black">
                  {{ feature.title }}
                </div>
                <div class="text-teal-500-neon">
                  {{ feature.description }}
                </div>
              </div>
            </div>
          </TransitionInViewportObserver>
        </div>
      </div>
    </section>

    <section class="mx-auto w-full max-w-screen-lg overflow-x-clip px-5 py-32">
      <div class="grid grid-cols-1 gap-4">
        <TransitionInViewportObserver
          v-for="(feature, index) in featureBanners"
          :key="feature.title"
          class="h-52"
          enter-active-class="transition-all duration-1000"
          leave-active-class="transition-all duration-1000"
          :enter-from-class="index % 2 === 0 ? 'translate-x-20 opacity-0' : '-translate-x-20 opacity-0'"
          leave-to-class="opacity-0">
          <div class="bg-base-300 p-4 ">
            {{ feature.title }}
            {{ feature.description }}
          </div>
        </TransitionInViewportObserver>
      </div>
    </section>
    <section class="relative mx-auto  w-full max-w-screen-lg overflow-x-clip px-5 py-32">
      <TransitionInViewportObserver
        class=" absolute"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class="h-44 w-44  rotate-12 bg-pink-200/10"></div>
      </TransitionInViewportObserver>
      <TransitionInViewportObserver
        class="absolute bottom-2 right-5 h-32 w-32"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="-translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class=" rotate-12 bg-pink-200/10"></div>
      </TransitionInViewportObserver>
      <div class="rounded-3xl border-4 border-pink-300  shadow-xl shadow-pink-500/50 ">
        <div class="rounded-md pt-10 text-center font-neon text-3xl font-black text-pink-500-neon">
          Our Premium<br>
          Supporter
        </div>
        <div class=" grid grid-cols-3 gap-5 p-10 text-base-content md:col-span-1 md:px-52">
          <TransitionInViewportObserver
            v-for="supporter in sponsors"
            :key="supporter"
            enter-active-class="transition-all duration-1000"
            leave-active-class="transition-all duration-1000"
            :enter-from-class="'scale-0 opacity-0'"
            leave-to-class="opacity-0">
            <div class="flex h-52 w-auto flex-col items-center gap-2">
              <template v-if="supporter.image">
                <div class="tooltip" :data-tip="supporter.name">
                  <img :src="supporter.image" class="">
                </div>
              </template>
              <template v-else>
                {{ supporter.name }}
              </template>
            </div>
          </TransitionInViewportObserver>
        </div>
        <div class="col-span-3 mb-10 mt-20 flex flex-col items-center">
          <a :href="supportings.fanbox" target="_blank" class="btn btn-outline btn-lg border-pink-300">
            サポーターになる
          </a>
        </div>
      </div>
    </section>

    <section class="relative mx-auto w-full max-w-screen-lg overflow-x-clip px-5 py-32">
      <TransitionInViewportObserver
        class=" absolute"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class="h-44 w-44  rotate-12 bg-sky-200/10"></div>
      </TransitionInViewportObserver>
      <TransitionInViewportObserver
        class="absolute bottom-2 right-5 h-32 w-32"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="-translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class=" rotate-12 bg-sky-200/10"></div>
      </TransitionInViewportObserver>
      <div class="grid auto-rows-min grid-cols-1 gap-2 rounded-3xl  border-4 border-sky-300  p-10 text-base-content shadow-xl shadow-sky-500/50 md:grid-cols-3 md:gap-10">
        <div class="col-span-1 rounded-md p-4 text-center font-neon text-3xl font-black text-sky-500-neon md:col-span-3">
          Service<br>
          Feedback
        </div>
        <div v-for="(column, columnIndex) in columns" :key="columnIndex" class="flex flex-col">
          <div v-for="(feedback, feedbackIndex) in column" :key="feedbackIndex">
            <TransitionInViewportObserver
              enter-active-class="transition-all duration-1000"
              leave-active-class="transition-all duration-1000"
              enter-from-class="translate-y-20 opacity-0"
              leave-to-class="opacity-0">
              <div class="chat chat-start">
                <div class="avatar chat-image">
                  <div class="w-10 rounded-full">
                    <img alt="profile" :src="feedback.gravatar_url">
                  </div>
                </div>
                <div class="chat-bubble">
                  {{ feedback.comment }}
                </div>
              </div>
            </TransitionInViewportObserver>
          </div>
        </div>

        <div class="col-span-1 mt-20 flex flex-col items-center md:col-span-3">
          <a :href="issueForms.feedback" target="_blank" class="btn btn-outline btn-lg border-sky-300">
            フィードバックを送る
          </a>
        </div>
      </div>
    </section>

    <section class="mx-auto my-20 flex flex-row items-center  justify-center gap-10 py-32">
      <div class="relative font-neon text-5xl text-emerald-300-neon">
        <div class="absolute left-20 top-7 h-14 w-40 bg-emerald-200/10"></div>
        developer
      </div>
      <a :href="developer.link" target="_blank">
        <img :src="developer.image" class="h-40 rounded-md">
      </a>
    </section>
  </AppLayout>
</template>
