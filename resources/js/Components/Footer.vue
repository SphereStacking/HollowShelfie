<script setup>
import { usePage, Link } from '@inertiajs/vue3'
const page = usePage()
const appName = page.props.config.appName ?? null
const credit = page.props.config.credit ?? null
const Twitter = page.props.config.twitter ?? null
const GitHub = page.props.config.github ?? null
const DiscordInvite = page.props.config.discordInvite ?? null
const issueForms = page.props.config.issueForms ?? []

const pages = {
  About: [
    { component: Link, url: route('about', 'app'), label: appName, target: '_self' },
    { component: Link, url: route('about', 'operation'), label: '運営', target: '_self' },
    { component: Link, url: route('about', 'advertisement'), label: '広告掲載', target: '_self' }
  ],
  // しばらくは必要ないためコメントアウト
  // Guides: [
  //   { url: route('guide', 'how-to-use'), label: '使い方', target: '_self' },
  //   { url: route('guide', 'frequently-asked-questions'), label: 'よくある質問と回答', target: '_self' }
  // ],
  Links: [
    { component: 'a', url: Twitter, label: 'X', target: '_blank' },
    { component: 'a', url: GitHub, label: 'GitHub', target: '_blank' },
    { component: 'a', url: DiscordInvite, label: 'Discord', target: '_blank' }
  ],
  Legal: [
    { component: Link, url: route('legal', 'terms-of-service'), label: '利用規約', target: '_self' },
    { component: Link, url: route('legal', 'privacy-policy'), label: 'プライバシーポリシー', target: '_self' },
    { component: Link, url: route('legal', 'commercial-transaction-law'), label: '特商法表記', target: '_self' }
  ],
  Issue: [
    { component: 'a', url: issueForms.feedback, label: 'フィードバックを送る', target: '_blank' },
    { component: 'a', url: issueForms.bug_report, label: 'バグを報告する', target: '_blank' },
    { component: 'a', url: issueForms.new_feature, label: '新機能のリクエスト', target: '_blank' }
  ],
  Info: [
    { component: Link, url: route('about', 'news'), label: 'お知らせ・リリース', target: '_self' },
    { component: Link, url: route('roadmap'), label: 'ロードマップ', target: '_self' }
  ]
}

</script>
<template>
  <footer class="space-y-4 bg-base-300 p-4 text-center">
    <div class="mx-auto grid max-w-4xl  grid-cols-2 gap-2 md:grid-cols-6 md:gap-12">
      <ApplicationMark class="col-span-3 row-span-full h-14 md:col-span-1" />
      <div v-for="(links, section) in pages" :key="section" class="text-left">
        <p class="text-lg font-bold">
          {{ section }}
        </p>
        <ul class="list-none">
          <li v-for="link in links" :key="link.url">
            <component
              :is="link.component" :href="link.url" class="text-sm hover:underline"
              :target="link.target">
              {{ link.label }}
            </component>
          </li>
        </ul>
      </div>
    </div>
    <p>{{ credit }}</p>
  </footer>
</template>

<style scoped>
</style>
