<script setup>
import axios from 'axios'

const props = defineProps({
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
  count: {
    type: Number,
    default: null
  },
  isFollowed: {
    type: Boolean,
    required: true
  },
})
const isFollowed = ref(props.isFollowed)
const count = ref(props.count)
const followUrl = props.followRoute
const unfollowUrl = props.unfollowRoute
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
  <div>
    <button
      :class="[
        isFollowed ? 'btn btn-success btn-sm hover:btn-error' : 'btn btn-outline btn-sm hover:btn-success',
        hasCount ? 'w-32' : 'w-40',
      ]"
      @mouseover="isFollowedBtnOver = true" @mouseleave="isFollowedBtnOver = false"
      @click="follow">
      <IconTypeMapper
        :type="isFollowed ? isFollowedBtnOver ? 'unFollowing' : 'followNeutral' : 'onFollowing'"
        class="text-xl" />
      {{ buttonLabel }}
      <div v-if="!hasCount" class="badge">
        {{ count }}
      </div>
    </button>
  </div>
</template>
<style lang="">

</style>
