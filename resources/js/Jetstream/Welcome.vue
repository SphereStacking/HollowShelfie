<script setup>
import ApplicationLogo from '@/Jetstream/ApplicationLogo.vue'
import { usePage, Link } from '@inertiajs/vue3'
const page = usePage()
const appName = page.props.config.appName ?? null
const adminUser = page.props.adminUser ?? null

</script>

<template>
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <Card>
      <template #title>
        <ApplicationLogo class="block h-12" />
      </template>

      <h1 class="text-2xl font-medium">
        {{ appName }} へようこそ！
      </h1>

      <div class="mt-6 ">
        <p class="text-xl font-bold">
          VRコミュニティをよりアクセスしやすく
        </p>
        <p> VR世界は現在、コミュニティが分断されていると感じています。</p>
        <br>
        <p class="font-bold">
          初めての出会いでその後が大きく左右します。
        </p>

        自分から探しに行かないとなかなか新しい体験を見つけるのは難しい。。<br>

        <br>
        演者、グループによるイベントの現在、過去、未来のイベントを簡単に探索し<br>
        異なるコミュニティ外の繋がりを見つけやすく。

        せっかく作成したフライヤーも一度きりで終わらせたく無い
        <br>

        <br>
        そんな思いで<span class="font-bold">ユーザー投稿型プラットフォーム</span>の開発を進めています。<br>
      </div>
    </Card>

    <Card>
      <template #title>
        <p class="text-2xl">
          パトロンの募集
        </p>
      </template>
      <div class="p-4">
        <div class="mb-4">
          <h2 class="text-lg font-bold">
            基本 無料
          </h2>
          <p>イベントの検索や閲覧やブックマーク等の基本的な機能は無料です</p>
        </div>
        <div class="mb-4">
          <h2 class="text-lg font-bold">
            支援 300円
          </h2>
          <p>開発を継続していくための運営・開発・サーバー費用に充てさせていただきます。</p>
        </div>
        <div class="mb-4">
          <h2 class="text-lg font-bold">
            団体 500円
          </h2>
          <p>Team機能の解放 ユーザー制限x5 </p>
        </div>
        <div class="mb-4">
          <h2 class="text-lg font-bold">
            個人/団体 3000円
          </h2>
          <p>翌月からスポンサーとして広告を掲載することができます。</p>
        </div>
        <div class="mb-4">
          <h2 class="text-lg font-bold">
            企業 要調整
          </h2>
          <p>翌月からスポンサーとして広告を掲載することができます。</p>
        </div>
      </div>
    </Card>

    <Card class="col-span-1 sm:col-span-2">
      <template #title>
        <p class="text-2xl">
          開発者について
        </p>
      </template>
      <div>
        <img :src="adminUser.dataile.photo_url" class="h-40 rounded-md">
      </div>
    </Card>
  </div>
</template>
