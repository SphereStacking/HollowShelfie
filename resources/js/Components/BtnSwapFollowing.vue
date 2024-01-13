<script setup>
import axios from 'axios'

const props = defineProps({
  screenName: {
    type: String,
    required: true,
    default: ''
  },
  count: {
    type: Number,
    default: null
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
  },
})
const isFollowed = ref(props.isFollowed)
const count = ref(props.count)
const followUrl = route(props.followRoute, props.screenName)
const unfollowUrl = route(props.unfollowRoute, props.screenName)
const hasCount = computed(() => props.count == null)
const isFollowedBtnOver = ref()

const follow = async () => {
  const url = isFollowed.value ? unfollowUrl : followUrl
  const method = isFollowed.value ? 'delete' : 'post'

  try {
    const response = await axios({
      method: method,
      url: url,
    })

    if (response.status >= 200 && response.status < 300) {
      // レスポンスが正常な場合、dataを反映させる
      count.value = response.data.followers_count
      isFollowed.value = response.data.is_followed
    }

    console.log(response.data)
  } catch (error) {
    console.error('Error:', error)
  }
}
const buttonLabel = computed(() => {
  if (isFollowed.value) {
    return isFollowedBtnOver.value ? 'Unfollow' : 'Following'
  } else {
    return 'Follow'
  }
})
</script>
<template>
  <button
    :class="[
      isFollowed ? 'btn btn-success btn-sm hover:btn-error' : 'btn btn-outline btn-sm hover:btn-success',
      hasCount ? 'w-32' : 'w-40',
    ]"
    @mouseover="isFollowedBtnOver = true" @mouseleave="isFollowedBtnOver = false"
    @click="follow">
    <Icon
      :icon="isFollowed ? isFollowedBtnOver ? 'line-md:account-remove' : 'line-md:account-small' : 'line-md:account-add'"
      class="text-xl" />
    {{ buttonLabel }}
    <div v-if="!hasCount" class="badge">
      {{ count }}
    </div>
  </button>
</template>
<style lang="">

</style>
