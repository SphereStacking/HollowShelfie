<script setup>
import { generateTwitterUrl } from '@/Utill/SnsShare'
import { usePage } from '@inertiajs/vue3'
const page = usePage()
const appName = page.props.config.appName ?? null
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  period: {
    type: String,
    required: true,
  },
  instanceNames: {
    type: Array,
    default: () => [],
    required: false,
  },
  organizerNames: {
    type: Array,
    default: () => [],
    required: false,
  },
  performerNames: {
    type: Array,
    default: () => [],
    required: false,
  },
  categoryNames: {
    type: Array,
    default: () => [],
    required: false,
  },
  tags: {
    type: Array,
    default: () => [],
    required: false,
  },
  route: {
    type: String,
    default: () => '',
    required: false,
  },
})

function getShareText() {
  return '[ #vShelf ] \n' +
   `✨ ${props.title}\n` +
   `🗓 ${props.period}\n` +
   `📍 ${props.instanceNames.join('')}\n` +
   `👥 ${props.organizerNames.join('')}\n` +
   `🎤 ${props.performerNames.join('')}\n` +
   `🧺 ${props.categoryNames.join('')}\n` +
   `🏷 ${props.tags.map((name) => name).join(' ')}\n` +
   `🔗 ${props.route}\n`
}

function openShareUrl() {
  // 新しいウィンドウでシェアURLを開く
  window.open(generateTwitterUrl({text: getShareText(), hashtags: [appName]}), '_blank')
}

</script>
<template>
  <button class="btn btn-xs" @click="openShareUrl()">
    <Icon icon="ri:twitter-x-fill" class="text-xl" />
  </button>
</template>
<style lang="">

</style>
