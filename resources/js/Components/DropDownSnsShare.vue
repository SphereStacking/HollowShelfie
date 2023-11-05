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
  <div class="dropdown dropdown-bottom dropdown-end ">
    <label tabindex="0">
      <slot></slot>
    </label>
    <ul tabindex="0" class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box ">
      <li>
        <a @click="share('twitter')">
          <Icon icon="ri:twitter-x-fill" class="text-xl" />
        </a>
      </li>
      <li>
        <a @click="share('facebook')">
          <Icon icon="ri:facebook-fill" color="#1877F2" class="text-xl" />
        </a>
      </li>
      <li>
        <a @click="share('misskey')">
          <Icon icon="simple-icons:misskey" color="#86B300" class="text-xl" />
        </a>
      </li>
      <li>
        <a @click="share('mastodon')">
          <Icon icon="ri:mastodon-fill" color="#3088D4" class="text-xl" />
        </a>
      </li>
      <li>
        <a @click="share('reddit')">
          <Icon icon="ri:reddit-line" color="orangered" class="text-xl" />
        </a>
      </li>
    </ul>
  </div>
</template>
<style lang="">

</style>
