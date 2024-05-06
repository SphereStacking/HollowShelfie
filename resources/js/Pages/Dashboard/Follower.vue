<script setup>
import { router, usePage, Link} from '@inertiajs/vue3'

const props = defineProps({
  followers: {
    type: Array,
    default: () => []
  }
})
const page = usePage()
const allFollowers = ref(props.followers.data)
const initialUrl = page.url
const initialtitle = page.title

const hasNextPage = () => props.followers.pagination.next_page_url !== null

const loadMoreFollowers = () => {
  console.log(window.history)
  if (!hasNextPage()) {
    return
  }
  router.visit(props.followers.pagination.next_page_url, {
    method: 'get',
    preserveState: true,
    preserveScroll: true,
    replace: true,
    only: ['followers'],
    onSuccess: () => {
      window.history.replaceState({}, initialtitle, initialUrl)
      allFollowers.value = [...allFollowers.value, ...props.followers.data]
    }
  })
}

const loadMoreIntersect = ref(null)

onMounted(() => {
  const observer = new IntersectionObserver(
    entries => entries.forEach(
      entry => entry.isIntersecting && loadMoreFollowers(), {
        rootMargin: '-150px 0px 0px 0px'
      }
    )
  )
  observer.observe(loadMoreIntersect.value)
})

</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        フォロワー
      </h2>
    </template>
    <div class="flex w-1/2 flex-col gap-2">
      <!-- {{ allFollowers }} -->
      <div v-for="follower in allFollowers" :key="follower.id">
        <div class="flex flex-row items-center gap-2">
          <div class="avatar">
            <div class="w-24 rounded">
              <img :src="follower.image_url">
            </div>
          </div>
          <div class="flex w-full flex-col gap-2">
            <div class="flex flex-row justify-between gap-2">
              <div class="link font-bold">
                <Link :href="follower.profile_url">
                  {{ follower.name }}
                </Link>
                <div class=" opacity-30">
                  @{{ follower.screen_name }}
                </div>
              </div>

              <BtnSwapFollowing
                :follow-route="route('follow')"
                :unfollow-route="route('unfollow')"
                :payload="{ id: follow.followable_id, type: follow.followable_type}"
                :screen-name="follower.screen_name"
                :is-followed="follower.auth_user.is_followed" />
            </div>
            <div>{{ follower.bio }}</div>
          </div>
        </div>
      </div>
      <span ref="loadMoreIntersect"></span>
      <button v-if="hasNextPage()" class="btn" @click="loadMoreFollowers()">
        もっと見る
      </button>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
