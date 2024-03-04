<script setup>
import { shareToSNS } from '@/Utill/SnsShare'

const props = defineProps({
  text: {
    type: String,
    required: true
  },
  url: {
    type: String,
    required: true,
  },
  hashtags: {
    type: String,
    default: () => '',
    required: false,
  },
  mention: {
    type: String,
    default: () => '',
    required: false,
  },
  instance: {
    type: String,
    default: () => '',
    required: false,
  },
})

const share = (platform) => {
  const options = {
    text: props.text,
    url: props.url,
    hashtags: props.hashtags,
    mention: props.mention,
    instance: props.instance,
  }
  shareToSNS(platform, options)
}

</script>
<template>
  <div class="">
    <button class="btn btn-xs" @click="share('twitter')">
      <Icon icon="ri:twitter-x-fill" class="text-xl" />
    </button>
    <!-- <button class="btn btn-xs" @click="share('facebook')">
      <Icon icon="ri:facebook-fill" color="#1877F2" class="text-xl" />
    </button>
    <button class="btn btn-xs" @click="share('misskey')">
      <Icon icon="simple-icons:misskey" color="#86B300" class="text-xl" />
    </button>
    <button class="btn btn-xs" @click="share('mastodon')">
      <Icon icon="ri:mastodon-fill" color="#3088D4" class="text-xl" />
    </button>
    <button class="btn btn-xs" @click="share('reddit')">
      <Icon icon="ri:reddit-line" color="orangered" class="text-xl" />
    </button> -->
  </div>
</template>
<style lang="">

</style>
