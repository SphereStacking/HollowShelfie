<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'

import { usePage, Link } from '@inertiajs/vue3'
const page = usePage()
const appName = page.props.config.appName ?? null
const user = page.props.user ?? null
const events = page.props.events ?? []

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
            未知なるイベントの世界へ一緒に踏み出しましょう。
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
    <section class="mx-auto w-full max-w-screen-lg overflow-x-clip px-5 pt-20">
      <div class="grid grid-cols-2 gap-1 rounded-md border-4 border-teal-300 p-2 text-base-content shadow-xl shadow-blue-500/50">
        <div class="col-span-2 rounded-md p-4  text-center text-3xl font-black">
          aaaaa
          <br>
          aa
        </div>
        <div class="rounded-md border-2 border-gray-300 bg-base-100/40 p-4">
          aaaaa
        </div>
        <div class="rounded-md border-2 border-gray-300 bg-base-100/40 p-4">
          aaaaa
        </div>
        <div class="rounded-md border-2 border-gray-300 bg-base-100/40 p-4">
          aaaaa
        </div>
        <div class="rounded-md border-2 border-gray-300 bg-base-100/40 p-4">
          aaaaa
        </div>
      </div>
    </section>

    <section class="mx-auto w-full max-w-screen-lg overflow-x-clip px-5 pt-20">
      <div class="grid grid-cols-1 gap-1">
        <div class="h-52 bg-base-300/10 p-4">
          イベントをいいねで応援！
        </div>
        <div class="h-52 bg-base-300/20  p-4">
          行きたいイベントをブックマーク！
        </div>
        <div class="h-52 bg-base-300/30  p-4">
          主催したイベント掲載して告知しよう！
        </div>
        <div class="h-52 bg-base-300/40  p-4">
          推しのオーガナイザー&パフォーマーをフォローしてイベントを見逃さない！
        </div>
      </div>
    </section>
    <section class="mx-auto  w-full max-w-screen-lg overflow-x-clip px-5 pt-20">
      <div class="grid grid-cols-3 gap-1 rounded-md  border-4 border-pink-300 p-2 text-base-content shadow-xl shadow-pink-500/50">
        <div class="col-span-3 rounded-md p-4 text-center text-3xl font-black">
          Our Premium<br>
          Sponsors
        </div>
        <div class="rounded-md border-2 border-gray-300 bg-base-100/40 p-4">
          aaaaa
        </div>
        <div class="rounded-md border-2 border-gray-300 bg-base-100/40 p-4">
          aaaaa
        </div>
        <div class="rounded-md border-2 border-gray-300 bg-base-100/40 p-4">
          aaaaa
        </div>
        <div class="rounded-md border-2 border-gray-300 bg-base-100/40 p-4">
          aaaaa
        </div>
        <div class="rounded-md border-2 border-gray-300 bg-base-100/40 p-4">
          aaaaa
        </div>
        <div class="rounded-md border-2 border-gray-300 bg-base-100/40 p-4">
          aaaaa
        </div>
      </div>
    </section>
    <div>
      <img :src="user.dataile.photo_url" class="h-40 rounded-md">
    </div>
  </AppLayout>
</template>
