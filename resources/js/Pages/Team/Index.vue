<script setup>
import { router, Link } from '@inertiajs/vue3'
const props = defineProps({
  profile: {
    type: Object,
    required: true
  },
  events: {
    type: Array,
    required: true
  },
  url: {
    type: String,
    required: true
  },
})

const dataile = props.profile.dataile
const authUser = ref({})
authUser.value = props.profile.auth_user

watch(authUser, (newVal, oldVal) => {
  console.log('authUser has changed', newVal, oldVal)
})

const isMounted = ref(false)
onBeforeMount(() => {
  setTimeout(() => {
    isMounted.value = true
  }, 500)
})

const getButtonText = (event) => {
  return `${event.name}`
}
const querySetter = (value, type) => {
  console.log(value)
  return [
    { include: 'and', type: 'user', value: props.profile.dataile.name },
    { include: 'and', type: type.toString(), value: value.name },
  ]
}
</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-neutral">
      </h2>
    </template>
    <div class="mx-auto my-6 flex max-w-7xl flex-col gap-4">
      <Card class="mt-10">
        <template #header>
        </template>
        <div class="-mt-10 flex flex-col items-center">
          <div class="hero">
            <div class="relative flex w-full flex-col gap-10 lg:flex-row">
              <div class=" group">
                <div
                  class="absolute -inset-2 bottom-0 origin-center  rounded-lg bg-accent  transition-all duration-700"
                  :class="isMounted ? ' w-52 h-52' : ' h-0 w-0 rotate-12  '">
                </div>
                <div class="avatar">
                  <div class="h-48 w-48">
                    <img :src="dataile.photo_url" class="absolute mx-auto h-full rounded-lg bg-base-300 shadow-2xl">
                  </div>
                </div>
              </div>
              <div class="flex w-full flex-col pt-10">
                <div class="flex flex-row justify-between">
                  <p class="text-center text-2xl  font-bold lg:text-left">
                    {{ dataile.name }}
                  </p>
                  <div class="flex items-end gap-4">
                    <button class="btn btn-circle btn-primary btn-sm">
                      <Icon icon="line-md:bell" class="text-xl" />
                    </button>
                    <BtnSwapFollowing
                      :follow-route="route('teams.follow', { id: dataile.screen_name })"
                      :unfollow-route="route('teams.unfollow', { id: dataile.screen_name })"
                      :count="dataile.followers_count"
                      :is-followed="authUser.is_followed" />
                    <button class="btn btn-neutral btn-sm flex flex-row ">
                      <Icon icon="line-md:email" class="text-xl" />
                      Connect
                    </button>
                  </div>
                </div>
                <div class="flex flex-row justify-between">
                  <div class="flex items-center py-2">
                    <LinkExts class="flex gap-1" :links="dataile.links" />
                  </div>
                  <div class="flex items-center gap-2">
                    <template v-for="badge in dataile.badges">
                      <Icon :icon="badge.icon_class" class="text-xl" />
                    </template>
                  </div>
                </div>
                <div class="parse h-full w-full rounded-lg bg-base-300 p-2">
                  {{ dataile.content }}
                </div>
                <div>
                  <div class="flex flex-row items-center gap-1">
                    <div class="mr-auto flex items-center gap-1  rounded-md">
                      <IconTypeMapper type="tag" class="text-xl" />
                      <template v-for="(tag, index) in dataile.tags" :key="index">
                        <BtnEventSearchItem
                          :button-text-setter="getButtonText" :query-setter="querySetter" :value="tag"
                          type="tag" is-navigate />
                      </template>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Card>

      <div class="my-2 grid w-full grid-cols-2  gap-6 sm:grid-cols-3  md:grid-cols-4 xl:grid-cols-6">
        <CardEvent
          v-for="(item, index) in props.events.data" :key="index" :event="item"
          scroll-region />
      </div>

      <Link :href="url" method="get" class=" btn btn-primary btn-sm">
        show more!
      </Link>
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
