<script setup>
import { router, usePage, Link} from '@inertiajs/vue3'

const props = defineProps({
  follows: {
    type: Array,
    default: () => []
  }
})
const page = usePage()
const allFollows = ref(props.follows.data)
const initialUrl = page.url
const initialtitle = page.title

const hasNextPage = () => props.follows.pagination.next_page_url !== null

const loadMoreFollows = () => {
  console.log(window.history)
  if (!hasNextPage()) {
    return
  }
  router.visit(props.follows.pagination.next_page_url, {
    method: 'get',
    preserveState: true,
    preserveScroll: true,
    replace: true,
    only: ['follows'],
    onSuccess: () => {
      window.history.replaceState({}, initialtitle, initialUrl)
      allFollows.value = [...allFollows.value, ...props.follows.data]
    }
  })
}

const loadMoreIntersect = ref(null)

onMounted(() => {
  const observer = new IntersectionObserver(
    entries => entries.forEach(
      entry => entry.isIntersecting && loadMoreFollows(), {
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
        ダッシュボード
      </h2>
    </template>
    <div class="flex w-1/2 flex-col gap-2">
      <!-- {{ allFollows }} -->
      <div v-for="follow in allFollows" :key="follow.id">
        <div class="flex flex-row items-center gap-2">
          <div class="avatar">
            <div class="w-24 rounded">
              <img :src="follow.followable.image_url">
            </div>
          </div>
          <div class="flex w-full flex-col gap-2">
            <div class="flex flex-row justify-between gap-2">
              <div class="link font-bold">
                <Link :href="follow.followable.profile_url">
                  {{ follow.followable.name }}
                </Link>
                <div class=" opacity-30">
                  @{{ follow.followable.screen_name }}
                </div>
              </div>

              <BtnSwapFollowing
                :follow-route="'users.follow'"
                :unfollow-route="'users.unfollow'"
                :screen-name="follow.followable.screen_name"
                :is-followed="follow.followable.auth_user.is_followed" />
            </div>
            <div>{{ follow.followable.bio }}</div>
          </div>
        </div>
      </div>
      <span ref="loadMoreIntersect"></span>
      <button v-if="hasNextPage()" class="btn" @click="loadMoreFollows()">
        もっと見る
      </button>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
