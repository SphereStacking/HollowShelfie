<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  screenName: {
    type: String,
    required: true,
    default: ''
  },
  count: {
    type: Number,
    required: true,
    default: 0
  },
  followRoute: {
    type: String,
    required: true,
    default: ''
  },
  unfollowRoute: {
    type: String,
    required: true,
    default: ''
  },
  isFollowed: {
    type: Boolean,
    required: true
  }
})

const followUrl = route(props.followRoute, props.screenName)
const unfollowUrl = route(props.unfollowRoute, props.screenName)

const isFollowedBtnOver = ref()
const follow = () => {
  if (!props.isFollowed) {
    router.visit(followUrl, {
      method: 'post',
      preserveState: false,
      preserveScroll: true,
      onSuccess: (result) => {
        console.log(result)
      }
    })
  } else {
    router.visit(unfollowUrl, {
      method: 'delete',
      preserveState: false,
      preserveScroll: true,
      onSuccess: (result) => {
        console.log(result)
      }
    })
  }
}
</script>
<template>
  <button
    :class="isFollowed ? 'btn  btn-sm btn-success hover:btn-error' : 'btn  btn-sm btn-outline hover:btn-success'"
    @mouseover="isFollowedBtnOver = true" @mouseleave="isFollowedBtnOver = false" @click="follow">
    <Icon
      :icon="isFollowed ? isFollowedBtnOver ? 'line-md:account-remove' : 'line-md:account-small' : 'line-md:account-add'"
      class="text-xl" />
    {{ isFollowed ? isFollowedBtnOver ? ' Un Follow' : 'Followed' : 'Follow' }}
    <div class="badge">
      {{ count }}
    </div>
  </button>
</template>
<style lang="">

</style>

