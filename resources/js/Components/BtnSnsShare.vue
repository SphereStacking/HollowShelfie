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
    default: () => [],
    required: false,
  },
  mention: {
    type: String,
    required: false,
  },
  instance: {
    type: String,
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
  <ul>
    <li>
      <a @click="share('twitter')" class="btn btn-xs">
        <Icon icon="ri:twitter-x-fill" class="text-xl" />
      </a>
    </li>
    <!-- <li>
      <a @click="share('facebook')" class="btn btn-xs">
        <Icon icon="ri:facebook-fill" color="#1877F2" class="text-xl" />
      </a>
    </li>
    <li>
      <a @click="share('misskey')" class="btn btn-xs">
        <Icon icon="simple-icons:misskey" color="#86B300" class="text-xl" />
      </a>
    </li>
    <li>
      <a @click="share('mastodon')" class="btn btn-xs">
        <Icon icon="ri:mastodon-fill" color="#3088D4" class="text-xl" />
      </a>
    </li>
    <li>
      <a @click="share('reddit')" class="btn btn-xs">
        <Icon icon="ri:reddit-line" color="orangered" class="text-xl" />
      </a>
    </li> -->
  </ul>
</template>
<style lang="">

</style>
