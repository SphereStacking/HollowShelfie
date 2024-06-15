<script setup>
import { usePage, Link } from '@inertiajs/vue3'
const page = usePage()
const dataile = page.props.profile.dataile
const authUser = page.props.profile.auth_user
const isAuthUser = page.props.isAuthUser
const querySetter = (value, type) => {
  return [
    { include: 'and', type: 'user', value: dataile.name },
    { include: 'and', type: type.toString(), value: value.name },
  ]

}

const hasLinks = computed(() => {
  return dataile.links.length > 0
})

const hasTags = computed(() => {
  return dataile.tags.length > 0
})

</script>
<template>
  <Card class="">
    <div class=" -mt-14 flex flex-col items-start gap-5 sm:-mt-20">
      <div class="flex w-full items-center justify-between gap-4">
        <div class="avatar">
          <div class="size-32 sm:size-48">
            <img :src="dataile.photo_url" class="mx-auto h-full rounded-lg bg-base-300 shadow-2xl">
          </div>
        </div>
        <div class="flex grow flex-col-reverse items-center justify-between gap-2 sm:flex-row">
          <div class="flex flex-col ">
            <div class="flex flex-col justify-start text-left ">
              <div class="truncate text-2xl font-bold">
                {{ dataile.name }}
              </div>
              <div class="text-md opacity-40">
                <template v-if="dataile.screen_name">
                  @{{ dataile.screen_name }}
                </template>
              </div>
            </div>
          </div>
          <div v-if="!isAuthUser" class="flex w-full justify-end">
            <BtnSwapFollowing
              class="hidden sm:block"
              :follow-route="route('follow', dataile.screen_name)"
              :unfollow-route="route('unfollow', dataile.screen_name)"
              :count="dataile.followers_count"
              :is-followed="authUser.is_followed" />
            <BtnSwapFollowingCircle
              class="block sm:hidden"
              :follow-route="route('follow', dataile.screen_name)"
              :unfollow-route="route('unfollow', dataile.screen_name)"
              :is-followed="authUser.is_followed" />
          </div>
          <div v-else class="flex w-full justify-end">
            <Link :href="route('profile.edit', dataile.screen_name)" class="btn btn-neutral btn-sm">
              Edit Profile
            </Link>
          </div>
        </div>
      </div>

      <div v-if="dataile.bio" class="w-full rounded-md bg-base-200 p-2 text-base">
        {{ dataile.bio }}
      </div>
      <div class="flex w-full flex-col gap-2 md:flex-row">
        <div v-if="hasLinks" class="flex w-1/2 flex-wrap items-center gap-3">
          <LinkWithFavicon v-for="item in dataile.links" :key="item.id" :link="item" />
        </div>
        <div v-if="hasTags" class="flex w-1/2 flex-wrap items-center gap-1">
          <IconTypeMapper type="tag" class="text-xl" />
          <template v-for="(tag, index) in dataile.tags" :key="index">
            <BtnEventSearchItem
              :query-setter="querySetter" :value="tag"
              type="tag" is-navigate />
          </template>
        </div>
      </div>
    </div>
  </Card>
</template>
<style scoped>

</style>
