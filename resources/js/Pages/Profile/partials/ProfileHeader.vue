<script setup>
import { usePage, Link } from '@inertiajs/vue3'
const page = usePage()
const getButtonText = (event) => {
  return `${event.name}`
}

const dataile = page.props.profile.dataile
const authUser = page.props.profile.auth_user
const isAuthUser = page.props.isAuthUser
const querySetter = (value, type) => {
  return [
    { include: 'and', type: 'user', value: dataile.name },
    { include: 'and', type: type.toString(), value: value.name },
  ]
}

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

      <div class=" w-full rounded-md bg-base-200">
        <div class="h-10 "></div>
      </div>
      <div class="flex w-full flex-col gap-2 md:flex-row">
        <div v-if="dataile.links.length > 0" class="flex w-1/2 items-center gap-1">
          <a
            v-for="item in dataile.links" :key="item.id" class="fel-row link flex items-center gap-0.5"
            :href="item.link">
            <IconTypeMapper type="link" class="text-xl" />
            {{ item.label }}
          </a>
        </div>
        <div v-if="dataile.tags.length > 0" class="flex w-1/2 items-center gap-1">
          <IconTypeMapper type="tag" class="text-xl" />
          <template v-for="(tag, index) in dataile.tags" :key="index">
            <BtnEventSearchItem
              :button-text-setter="getButtonText" :query-setter="querySetter" :value="tag"
              type="tag" is-navigate />
          </template>
        </div>
      </div>
    </div>
  </Card>
</template>
<style scoped>

</style>
