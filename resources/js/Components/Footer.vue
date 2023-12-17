<script setup>
import { usePage } from '@inertiajs/vue3';
const page = usePage()
const appName = page.props.config.appName ?? null
const credit = page.props.config.credit ?? null
const Twitter = page.props.config.twitter ?? null
const GitHub = page.props.config.github ?? null

const pages = {
  About: [
    { url: route('about', 'app'), label: appName, target: '_self' },
    { url: route('about', 'operation'), label: '運営', target: '_self' },
    { url: route('about', 'news'), label: 'お知らせ・リリース', target: '_self' }
  ],
  Guides: [
    { url: route('guide', 'how-to-use'), label: '使い方', target: '_self' },
    { url: route('guide', 'frequently-asked-questions'), label: 'よくある質問と回答', target: '_self' }
  ],
  Links: [
    { url: Twitter, label: 'Twitter', target: '_blank' },
    { url: GitHub, label: 'GitHub', target: '_blank' },
  ],
  Legal: [
    { url: route('legal', 'terms-of-service'), label: '利用規約', target: '_self' },
    { url: route('legal', 'privacy-policy'), label: 'プライバシーポリシー', target: '_self' },
    { url: route('legal', 'commercial-transaction-law'), label: '特商法表記', target: '_self' }
  ]
}

</script>
<template>
  <footer class="p-4 bg-base-300 text-center space-y-4">
    <div class="grid grid-cols-2 gap-2  md:grid-cols-5 md:gap-20 max-w-4xl mx-auto">
      <ApplicationMark class="h-14 sm:col-span-1 col-span-2"></ApplicationMark>
      <div v-for="(links, section) in pages" :key="section" class="text-left">
        <p class="font-bold text-lg">{{ section }}</p>
        <ul class="list-none">
          <li v-for="link in links" :key="link.url">
            <a :href="link.url" class="hover:underline text-sm" :target="link.target">{{ link.label }}</a>
          </li>
        </ul>
      </div>
    </div>
    <p>{{ credit }}</p>
  </footer>
</template>

<style scoped>
</style>
