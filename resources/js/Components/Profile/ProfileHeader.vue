<script setup>
const props = defineProps({
  name: {
    type: String,
    required: true
  },
  header_photo_url: {
    type: String,
    required: true
  },
  followersCount: {
    type: Number,
    required: true
  },
  badges: {
    type: Array,
    required: true
  },
  isFollowed: {
    type: Boolean,
    required: true
  }
})
defineEmits(
  ['click']
)
const isFollowedBtnOver = ref()
</script>
<template>
  <Card class="">
    <template #header>
      <figure>
        <img src="https://vojislavd.com/ta-template-demo/assets/img/profile-background.jpg" class="">
      </figure>
    </template>
    <div class="flex flex-col items-center -mt-20">
      <img :src="header_photo_url" class="w-40 border-4 border-white rounded-full">
      <div class="flex items-center mt-2">
        <p class="text-2xl">{{ name }}</p>
      </div>
      <div class="flex items-center gap-2">
        <Icon v-for="badge in badges" :icon="badge"></Icon>
      </div>
    </div>
    <div class="flex-1 flex flex-col items-center lg:items-end justify-end px-8 mt-2">
      <div class="flex items-center space-x-4 mt-2">
        <!-- TODO: 通知機能 -->
        <!-- <button class="btn btn-circle  btn-primary">
          <Icon icon="line-md:bell" class="text-xl"></Icon>
        </button> -->
        <button :class="isFollowed ? 'btn btn-success hover:btn-error' : 'btn btn-outline hover:btn-success'"
          @mouseover="isFollowedBtnOver = true" @mouseleave="isFollowedBtnOver = false">
          <Icon
            :icon="isFollowed ? isFollowedBtnOver ? 'line-md:account-remove' : 'line-md:account-small' : 'line-md:account-add'"
            class="text-xl"></Icon>
          {{ isFollowed ? isFollowedBtnOver ? ' Un Follow' : 'Followed' : 'Follow' }}
          <div class="badge">{{ followersCount }}</div>
        </button>
        <button class="btn btn-neutral flex flex-row">
          <Icon icon="line-md:email" class="text-xl"></Icon>
          Connect
        </button>
      </div>
    </div>
  </Card>
</template>
