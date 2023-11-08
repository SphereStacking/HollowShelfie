<script setup>
const props = defineProps({
  profile: {
    type: String,
    required: true
  },
})

const dataile = props.profile.dataile
const authUser = props.profile.auth_user
const logs = props.profile.logs
const events = props.profile.events

</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-neutral">
      </h2>
    </template>

    <div class="max-w-7xl mx-auto my-6">
      <ProfileHeader :name="dataile.name" :header_photo_url="dataile.photo_url" :followersCount="dataile.followers_count"
        :badges="dataile.badges" :isFollowed="authUser.is_followed">
      </ProfileHeader>
      <div class="mt-4 flex flex-col 2xl:flex-row space-y-4 2xl:space-y-0 2xl:space-x-4">
        <div class="w-full flex flex-col 2xl:w-1/3">
          <ProfileDatail class="flex-1 p-4" :name="dataile.name" :join_at="dataile.join_at" :location="dataile.location"
            :languages="dataile.languages" :links="dataile.links"></ProfileDatail>
          <HistoryTimeLine class="flex-1 mt-4 p-4" :histories="logs"></HistoryTimeLine>
        </div>
        <ProfileBio :content="dataile.bio"></ProfileBio>
      </div>
      <CardShowMoreEvents section="organized" title="主催" :events="events.organized" class="mt-4"> </CardShowMoreEvents>
      <CardShowMoreEvents section="performered" title="出演" :events="events.performered" class="mt-4">
      </CardShowMoreEvents>
    </div>

  </AppLayout>
</template>
<style lang="">

</style>
