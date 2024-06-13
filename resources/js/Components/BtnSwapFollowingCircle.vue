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
  isFollowed: {
    type: Boolean,
    required: true
  },
})
const isFollowed = ref(props.isFollowed)
const count = ref(props.count)
const followUrl = props.followRoute
const unfollowUrl = props.unfollowRoute
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

</script>
<template>
  <div class="">
    <button
      class="btn btn-circle btn-md"
      :class="[
        isFollowed ? 'btn-success hover:btn-error' : 'btn-outline hover:btn-success',
      ]"
      @mouseover="isFollowedBtnOver = true" @mouseleave="isFollowedBtnOver = false"
      @click="follow">
      <IconTypeMapper
        :type="isFollowed ? isFollowedBtnOver ? 'unFollowing' : 'followNeutral' : 'onFollowing'"
        class="text-3xl" />
    </button>
  </div>
</template>
<style lang="">

</style>
