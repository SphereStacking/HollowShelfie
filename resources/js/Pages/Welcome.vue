<script setup>
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
const images = page.props.images

// アイコンタイプ、ラベル、説明のデータ構造を定義
const AppStatuses = [
  // { type: 'trend', label: 'PV', description: 'サイトへのアクセス数です。', count: 0 },
  { type: 'organizer', label: 'User', image: images.smiling_face, description: '累計ユーザー数', count: userCount },
  { type: 'event', label: 'Event', image: images.cracker, description: '累計イベント数', count: eventCount },
]
const features = [
  { icon: 'good', description: '評価' },
  { icon: 'bookmarks', description: 'ブックマーク' },
  { icon: 'event', description: 'イベントの掲載' },
  { icon: 'search', description: 'イベントの検索' },
  { icon: 'follow', description: 'フォロー'},
  { icon: 'timeline', description: 'タイムライン表示' },
  { icon: 'notification', description: '通知', plan: 'free / coming soon', isComingSoon: true },
  { icon: 'team', description: 'チーム', plan: 'standard / coming soon', isComingSoon: true },
  { icon: 'matching', description: '主催者と演者のマッチング', plan: 'standard / coming soon', isComingSoon: true },
  { icon: 'advertisement', description: 'バナー掲載', plan: 'premium / coming soon', isComingSoon: true },
]
const featureBanners = [
  { title: 'フライヤーを飾れる', description: '拘って作ったフライヤーを飾って見返せるようにして、活動のログをフライヤーで記録しよう！' },
  { title: 'イベントをいいねで応援！', description: 'あなたの一つの「いいね」が、イベントの魅力を多くの人へと伝える力になります。イベントページで気に入ったものに「いいね」をして、主催者を応援しよう！' },
  { title: '行きたいイベントをブックマーク！', description: '「行きたい！」と思ったイベントはブックマーク機能を使って保存しましょう。後で簡単にアクセスできるようになり、あなたの興味に合ったイベントを見逃さないように！' },
]
const plans = [
  {
    title: 'Default',
    price: 'Free',
    supplement: '含まれる',
    features: ['基本機能'],
    isComingSoon: false,
    link: { label: '登録', url: '/register' }
  },
  {
    title: 'Standard',
    price: '500/月',
    supplement: '基本の全てに加えて、',
    features: ['チーム', 'マッチング掲載', '記事投稿', 'カスタムurl'],
    isComingSoon: true,
    link: { label: 'coming soon...?', url: '#' }
  },
  {
    title: 'Premium',
    price: '1000～/月',
    supplement: 'スタンダードの全てに加えて、',
    features: ['広告掲載', 'バナー掲載件', 'イベントレコメンド', ],
    isComingSoon: true,
    link: { label: 'coming soon...?', url: '#' }
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
  <LandingPageLayout title="welcome">
    <section class="flex min-h-[calc(100vh-4rem)] items-center justify-center px-2 text-center">
      <ApplicationLogo class="sticky top-10 h-20 py-2 text-base-content md:flex-row" />
    </section>
    <section class="flex items-center justify-center py-32 text-center md:min-h-[calc(100vh-4rem)]">
      <div class=" sticky top-10 text-center  font-black">
        <div class="text-center font-title text-[clamp(2rem,6vw,4.2rem)] font-black leading-[1.1] [word-break:auto-phrase] xl:w-[115%] xl:text-start [:root[dir=rtl]_&]:leading-[1.35]">
          <div class="inline-grid">
            <div class="pointer-events-none col-start-1 row-start-1 bg-[linear-gradient(90deg,theme(colors.error)_0%,theme(colors.secondary)_9%,theme(colors.secondary)_42%,theme(colors.primary)_47%,theme(colors.accent)_100%)] bg-clip-text text-center blur-xl [-webkit-text-fill-color:transparent] [transform:translate3d(0,0,0)] before:content-[attr(data-text)] [@supports(color:oklch(0%_0_0))]:bg-[linear-gradient(90deg,oklch(var(--s))_4%,color-mix(in_oklch,oklch(var(--s)),oklch(var(--er)))_22%,oklch(var(--p))_45%,color-mix(in_oklch,oklch(var(--p)),oklch(var(--a)))_67%,oklch(var(--a))_100.2%)]">
              フライヤーを飾れる
              <br>
              イベント共有サービス
            </div>
            <div class="relative col-start-1 row-start-1 bg-[linear-gradient(90deg,theme(colors.error)_0%,theme(colors.secondary)_9%,theme(colors.secondary)_42%,theme(colors.primary)_47%,theme(colors.accent)_100%)] bg-clip-text text-center [-webkit-text-fill-color:transparent] [&::selection]:bg-blue-700/20 [&::selection]:text-base-content [@supports(color:oklch(0%_0_0))]:bg-[linear-gradient(90deg,oklch(var(--s))_4%,color-mix(in_oklch,oklch(var(--s)),oklch(var(--er)))_22%,oklch(var(--p))_45%,color-mix(in_oklch,oklch(var(--p)),oklch(var(--a)))_67%,oklch(var(--a))_100.2%)]">
              フライヤーを飾れる
              <br>
              イベント共有サービス
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="min-h-[calc(100vh-4rem)] w-full overflow-x-clip p-10 md:px-20">
      <div class="mt-20 flex flex-col items-center justify-around gap-10 md:flex-row md:gap-0">
        <div class=" items-center text-4xl font-bold">
          <div>
            新しい体験を<br>
            <br>
            ここから見つけよう！<br>
            <br>
            未知なるイベントの世界へ
          </div>
        </div>
        <div class="flex flex-row items-center gap-20 md:flex-col md:gap-4">
          <img :src="images.ghost">
          <div class="flex flex-col gap-2">
            <Link href="/home" class="btn btn-primary btn-lg ">
              イベントを探す
            </Link>
            <Link href="/register" class="btn btn-link btn-sm ">
              今すぐ登録
            </Link>
          </div>
        </div>
      </div>
      <div class="flex flex-row items-center justify-around  py-20 md:p-32">
        <div v-for="status in AppStatuses" :key="status.type" class="group">
          <div class="flex flex-row items-center justify-center gap-2">
            <div class="flex size-20 items-center justify-center rounded-xl bg-base-100 transition-all duration-200">
              <img :src="status.image" class="size-10 transition-all duration-200">
            </div>
            <div class="text-left">
              {{ status.description }} <br>
              {{ status.count }}
            </div>
          </div>
        </div>
      </div>

      <div class=" flex animate-slide-infinite flex-row p-5">
        <CardEventCompact
          v-for="event in events" :key="event.id" :event="event"
          class="m-5  w-40" />
        <CardEventCompact
          v-for="event in events" :key="event.id" :event="event"
          class="m-5 w-40" />
      </div>
    </section>

    <section class=" relative mx-auto min-h-[calc(100vh-4rem)] w-full max-w-screen-lg overflow-x-clip p-10 md:px-20 md:py-32">
      <TransitionInViewportObserver
        class=" absolute"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class="size-44 rotate-12  bg-teal-200/10"></div>
      </TransitionInViewportObserver>
      <TransitionInViewportObserver
        class="absolute bottom-2 right-5 size-32"
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
        <div class=" grid grid-cols-1 gap-5 p-10 text-base-content md:grid-cols-2 md:px-52">
          <TransitionInViewportObserver
            v-for="(feature, index) in features"
            :key="feature"
            enter-active-class="transition-all duration-1000"
            leave-active-class="transition-all duration-1000"
            :enter-from-class="index % 2 === 0 ? '-translate-x-20 opacity-0' : 'translate-x-20 opacity-0'"
            leave-to-class="opacity-0">
            <div
              class="indicator flex  w-full flex-row items-center rounded-md p-4"
              :class="feature.isComingSoon ? 'bg-base-100/30' : 'bg-base-100'">
              <span v-if="feature.plan" class="badge indicator-item translate-x-2 text-base-content">
                {{ feature.plan }}
              </span>
              <div class="flex flex-row items-center gap-2">
                <IconTypeMapper :type="feature.icon" class="size-10" />
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

    <section class="mx-auto w-full max-w-screen-lg overflow-x-clip px-20 py-10 md:py-24">
      <div class="grid grid-cols-1 gap-32">
        <TransitionInViewportObserver
          v-for="(feature, index) in featureBanners"
          :key="feature.title"
          enter-active-class="transition-all duration-1000"
          leave-active-class="transition-all duration-1000"
          :enter-from-class="index % 2 === 0 ? 'translate-x-20 opacity-0' : '-translate-x-20 opacity-0'"
          leave-to-class="opacity-0">
          <div class="flex justify-between gap-4 " :class="index % 2 === 0 ? 'flex-col md:flex-row' : 'flex-col-reverse md:flex-row-reverse'">
            <div class="flex flex-col gap-2">
              <div class=" text-4xl font-black">
                {{ feature.title }}
              </div>
              <div class="text-base">
                {{ feature.description }}
              </div>
            </div>
          </div>
        </TransitionInViewportObserver>
      </div>
    </section>
    <section class="relative mx-auto  min-h-[calc(100vh-4rem)] w-full max-w-screen-lg overflow-x-clip p-10 md:px-20 md:py-32">
      <TransitionInViewportObserver
        class=" absolute"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class="size-44 rotate-12  bg-pink-200/10"></div>
      </TransitionInViewportObserver>
      <TransitionInViewportObserver
        class="absolute bottom-2 right-5 size-32"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="-translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class=" rotate-12 bg-pink-200/10"></div>
      </TransitionInViewportObserver>
      <div class="rounded-3xl border-4 border-pink-300  shadow-xl shadow-pink-500/50 ">
        <div class="rounded-md pt-10 text-center font-neon text-3xl font-black text-pink-500-neon">
          My Special<br>
          Supporter
        </div>
        <div class="grid grid-cols-3 gap-5 p-10 text-base-content md:col-span-1 md:px-52">
          <TransitionInViewportObserver
            v-for="supporter in sponsors"
            :key="supporter"
            enter-active-class="transition-all duration-1000"
            leave-active-class="transition-all duration-1000"
            :enter-from-class="'scale-0 opacity-0'"
            leave-to-class="opacity-0">
            <div class="flex h-52 w-auto flex-col items-center gap-2">
              <a :href="supporter.url" target="_blank">
                <template v-if="supporter.image">
                  <div class="tooltip" :data-tip="supporter.name">
                    <img :src="supporter.image" class="">
                  </div>
                </template>
                <template v-else>
                  {{ supporter.name }}
                </template>
              </a>
            </div>
          </TransitionInViewportObserver>
        </div>
        <div class="col-span-3 mb-10 mt-20 flex flex-col items-center justify-center gap-10 sm:flex-row">
          <a :href="supportings.fanbox" target="_blank" class="btn btn-outline btn-lg border-pink-300">
            Fanbox
          </a>
          <a :href="supportings.patreon" target="_blank" class="btn btn-outline btn-lg border-pink-300">
            Patreon
          </a>
        </div>
      </div>
    </section>

    <section class="relative mx-auto min-h-[calc(100vh-4rem)] w-full max-w-screen-lg overflow-x-clip p-10 md:px-20 md:py-32">
      <TransitionInViewportObserver
        class=" absolute"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class="size-44 rotate-12  bg-sky-200/10"></div>
      </TransitionInViewportObserver>
      <TransitionInViewportObserver
        class="absolute bottom-2 right-5 size-32"
        enter-active-class="transition-all duration-1000 rotate-90"
        leave-active-class="transition-all duration-1000"
        enter-from-class="-translate-x-20 opacity-0 rotate-90"
        leave-to-class="opacity-0">
        <div class=" rotate-12 bg-sky-200/10"></div>
      </TransitionInViewportObserver>
      <div class="grid auto-rows-min  gap-2 rounded-3xl  border-4 border-sky-300  p-10 text-base-content shadow-xl shadow-sky-500/50 md:grid-cols-3 md:gap-10">
        <div class="rounded-md p-4 text-center font-neon text-3xl font-black text-sky-500-neon md:col-span-3">
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
    <section class="relative mx-auto w-full max-w-screen-lg overflow-x-clip p-10 md:px-20 md:py-32">
      <div class="rounded-md py-10 text-center font-neon text-3xl font-black text-yellow-500-neon">
        Pricing
      </div>
      <div class="grid grid-cols-1 gap-4  md:grid-cols-3 ">
        <div
          v-for="plan in plans" :key="plan"
          class="relative flex flex-col justify-between rounded-lg bg-base-200 p-6 shadow-lg">
          <div v-if="plan.isComingSoon" class="absolute left-0 top-0 size-full rounded-lg bg-base-300/80"></div>
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
            :href="plan.link.url"
            class="btn btn-outline w-full">
            {{ plan.link.label }}
          </a>
        </div>
      </div>
    </section>
    <section class="mx-auto flex min-h-[calc(100vh-4rem)] flex-col   items-center justify-center gap-8 py-10  md:gap-10 md:py-20">
      <TransitionInViewportObserver
        enter-active-class="transition-all duration-1000"
        leave-active-class="transition-all duration-1000"
        enter-from-class=" scale-30 opacity-0"
        leave-to-class="opacity-0">
        <ApplicationLogo class="sticky top-0 h-20 py-2 text-base-content md:flex-row" />
      </TransitionInViewportObserver>
      <div class="flex flex-col items-center justify-center gap-8  overflow-hidden py-10 md:flex-row  md:gap-10">
        <div class="relative p-5 py-3 font-neon text-5xl text-emerald-300-neon">
          <TransitionInViewportObserver
            enter-active-class="transition-all duration-1000"
            leave-active-class="transition-all duration-1000"
            enter-from-class="-translate-x-20 opacity-0"
            leave-to-class="opacity-0">
            <div class="absolute left-20 top-7 h-14 w-40 bg-emerald-200/10"></div>
          </TransitionInViewportObserver>
          developer
        </div>

        <a
          :href="developer.link" target="_blank" class="tooltip"
          data-tip="sphere">
          <img :src="developer.image" class="h-40 rounded-xl">
        </a>
      </div>
    </section>
  </LandingPageLayout>
</template>
