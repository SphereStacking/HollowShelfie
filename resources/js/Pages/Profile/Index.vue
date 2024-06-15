<script setup>
import { Link } from '@inertiajs/vue3'
import { GetProfileMetaTags } from '@/Modules/MetaTag/metaTagHelpers'
const metaTags = GetProfileMetaTags()

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

const authUser = ref({})
authUser.value = props.profile.auth_user

</script>
<template>
  <AppLayout title="Dashboard" :meta-tags="metaTags">
    <template #header>
      <h2 class="text-xl font-semibold  leading-tight">
        Profile
      </h2>
    </template>
    <ProfileHeader class="mt-28" />
    <div class="mx-auto my-6 flex max-w-7xl flex-col gap-4">
      <ProfileTeamMenbers :profile="props.profile" />
      <ProfileUserJoinedTeams :profile="props.profile" :joined-teams="props.profile.dataile.teams" />
      <ProfileEvents :events="props.events" />

      <div class=" flex justify-center py-10">
        <Link :href="url" method="get" class=" btn btn-primary btn-md px-10">
          show more!
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
