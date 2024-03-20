<script setup>
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
import AppLayout from '@/Layouts/AppLayout.vue'

import { usePage, Link } from '@inertiajs/vue3'
const page = usePage()
const user = page.props.user ?? null
const events = page.props.events ?? []
const eventCount = page.props.eventCount ?? 0
const userCount = page.props.userCount ?? 0
const issueForms = page.props.config.issueForms ?? []
const supportings = page.props.config.supportings ?? []

// アイコンタイプ、ラベル、説明のデータ構造を定義
const AppStatuses = [
  { type: 'trend', label: 'PV', description: 'サイトへのアクセス数です。', count: 0 },
  { type: 'organizer', label: 'User', description: '登録されているユーザー数です。', count: userCount },
  { type: 'event', label: 'Event', description: '開催予定のイベント数です。', count: eventCount },
]
const Supporters=[
  {name: 'hoge一郎', image: ''},
  {name: 'fuga二郎', image: ''},
  {name: 'piyo三郎', image: ''},
]
const features =[
  {
    icon: 'matching',
    description: '主催者と演者のマッチング'
  },
  {
    icon: 'schedule',
    description: 'スケジューリング'
  },
  {
    icon: 'good',
    description: 'グッド'
  },
  {
    icon: 'bookmarks',
    description: 'ブックマーク'
  },
  {
    icon: 'event',
    description: 'イベントの主催'
  },
  {
    icon: 'search',
    description: 'イベントの検索'
  },
  {
    icon: 'team',
    description: 'チーム'
  },
  {
    icon: 'follow',
    description: 'フォロー'
  },
]
const featureBanners =[
  {
    title: 'イベントをいいねで応援！',
    description: 'イベントをいいねで応援！'
  },
  {
    title: '行きたいイベントをブックマーク！',
    description: '行きたいイベントをブックマークして、あなたの興味に合ったイベントを簡単に見つけましょう。'
  },
  {
    title: '主催するイベント掲載して告知しよう！',
    description: 'あなたが主催するイベントを掲載して、多くの人に知ってもらいましょう。'
  },
  {
    title: '推しのオーガナイザー&パフォーマーをフォローしてイベントを見逃さない！',
    description: 'お気に入りのオーガナイザーやパフォーマーをフォローして、最新のイベント情報を逃さずチェックしましょう。'
  }
]

const descriptions = [
  'このアプリケーションは、使いやすさと直感的なデザインを重視しており、初めての方でも簡単にナビゲートできます。毎日の生活に役立つ機能が満載で、あなたの時間をより有意義に使えるように設計されています。',
  '私たちはユーザーのフィードバックを真摯に受け止め、アプリケーションの機能改善に常に取り組んでいます。最新のアップデートでは、多くの新機能を追加し、使い勝手をさらに向上させました。',
  'このアプリケーションは、あなたの日常生活をサポートするために開発されました。スケジュール管理から健康管理、趣味の追求まで、あらゆるニーズに対応する機能が備わっています。',
  '革新的な技術を駆使して開発されたこのアプリは、業界内で高い評価を受けています。ユーザーにとって最高の体験を提供するために、最先端の機能と直感的なインターフェースを組み合わせています。',
  '友達や家族とのコミュニケーションをより豊かにするための機能が満載のこのアプリは、あなたの社会生活を次のレベルに引き上げます。メッセージング、写真共有、イベントの計画など、さまざまな機能を通じて大切な人とのつながりを深めることができます。',
  'このアプリケーションは、デザインと機能性の完璧なバランスを実現しています。美しいデザインに加え、ユーザーの日々のニーズに応えるための実用的な機能が充実しており、あらゆるシーンで活躍します。',
  'セキュリティとプライバシーを最優先に考え、ユーザーが安心して利用できる環境を提供しています。最新のセキュリティ技術を採用し、個人情報の保護に努めています。',
  'このアプリケーションは、あなたの創造性と生産性を最大限に引き出すためのツールです。アイデアを形にするための豊富な機能と、効率的なワークフローをサポートするデザインが特徴です。',
  '世界中のユーザーとつながり、新しい発見をするためのプラットフォームを提供します。異文化交流や言語学習など、あなたの好奇心を満たすための機能が満載です。',
  'このアプリは革命をもたらしました！',
  '素晴らしい体験ができました。',
  '使いやすくてとても便利です。',
  '毎日使っています！',
  '友達にもおすすめしました。',
  'デザインが美しく、機能も充実しています。',
  'サポートが手厚く、安心して利用できます。',
  '更新ごとに良くなっていくのが楽しみです。',
  'このアプリなしでは生活できません。',
  '常に使っている最高のアプリです。'
]

const feedbacks = Array.from({ length: 10 }, (_, index) => ({
  profile_photo: `https://source.unsplash.com/random/300x300/?portrait&sig=${index}`,
  description: descriptions[Math.floor(Math.random() * descriptions.length)]
}))
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
    <section class="mt-20 flex flex-row items-center justify-around">
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
    <section class="mt-20 overflow-hidden whitespace-nowrap">
      <div class="inline-block animate-slide-infinite p-5">
        <CardEvent
          v-for="event in events" :key="event.id" :event="event"
          class="m-5 inline-block w-40" />
        <CardEvent
          v-for="event in events" :key="event.id" :event="event"
          class="m-5 inline-block w-40" />
      </div>
    </section>
    <section class=" relative mx-auto w-full max-w-screen-lg overflow-x-clip px-5 pt-20">
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
      <div class="flex w-full flex-row justify-around gap-2">
        <div class="h-10 w-5 rounded-t-xl bg-teal-300 shadow-teal-500/50"></div>
        <div class="h-10 w-5 rounded-t-xl bg-teal-300 shadow-teal-500/50"></div>
      </div>

      <div class="rounded-3xl border-4 border-teal-300  shadow-xl shadow-teal-500/50 text-teal-500-neon">
        <div class="rounded-md pt-10 text-center font-neon text-3xl font-black ">
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
            <div class="flex w-full  flex-row items-center rounded-md bg-base-200 p-4">
              <div class="flex flex-row items-center gap-2">
                <IconTypeMapper :type="feature.icon" class="h-10 w-10" />
              </div>
              <div class="ml-4">
                <div class="text-2xl font-black">
                  {{ feature.title }}
                </div>
                <div>
                  {{ feature.description }}
                </div>
              </div>
            </div>
          </TransitionInViewportObserver>
        </div>
      </div>
    </section>

    <section class="mx-auto w-full max-w-screen-lg overflow-x-clip px-5 pt-20">
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
    <section class="relative mx-auto  w-full max-w-screen-lg overflow-x-clip px-5 pt-20">
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
      <div class="flex w-full flex-row justify-around gap-2">
        <div class="h-10 w-5 rounded-t-xl bg-pink-300 shadow-pink-500/50"></div>
        <div class="h-10 w-5 rounded-t-xl bg-pink-300 shadow-pink-500/50"></div>
      </div>
      <div class="rounded-3xl border-4 border-pink-300  shadow-xl shadow-pink-500/50 ">
        <div class="rounded-md pt-10 text-center font-neon text-3xl font-black text-pink-500-neon">
          Our Premium<br>
          Supporter
        </div>
        <div class=" grid grid-cols-3 gap-5 p-10 text-base-content md:col-span-1 md:px-52">
          <TransitionInViewportObserver
            v-for="supporter in Supporters"
            :key="supporter"
            enter-active-class="transition-all duration-1000"
            leave-active-class="transition-all duration-1000"
            :enter-from-class="'scale-0 opacity-0'"
            leave-to-class="opacity-0">
            <div class="p-4 text-center">
              {{ supporter.name }}
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

    <section class="relative mx-auto w-full max-w-screen-lg overflow-x-clip px-5 pt-20">
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
      <div class="flex w-full flex-row justify-around gap-2">
        <div class="h-10 w-5 rounded-t-xl bg-sky-300 shadow-sky-500/50"></div>
        <div class="h-10 w-5 rounded-t-xl bg-sky-300 shadow-sky-500/50"></div>
      </div>
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
                    <img alt="profile" :src="feedback.profile_photo">
                  </div>
                </div>
                <div class="chat-bubble">
                  {{ feedback.description }}
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

    <div class="mx-auto my-20 flex flex-row items-center  justify-center gap-10">
      <div class="relative font-neon text-5xl text-emerald-300-neon">
        <div class="absolute left-20 top-7 h-14 w-40 bg-emerald-200/10"></div>
        developer
      </div>
      <img :src="user.dataile.photo_url" class="h-40 rounded-md">
    </div>
  </AppLayout>
</template>
