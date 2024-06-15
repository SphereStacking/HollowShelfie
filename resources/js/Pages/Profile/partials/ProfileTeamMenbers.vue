<script setup>
import { usePage } from '@inertiajs/vue3'
const page = usePage()
const detail = ref(page.props.profile.detail)
const type = ref(page.props.profile.type)
const isTeamProfile = computed(() => {
  return type.value === 'team'
})
</script>
<template>
  <div v-if="isTeamProfile">
    <div class="divider divider-end mt-5 w-full text-2xl font-bold">
      <div>
        <IconTypeMapper type="user" />
      </div>
      <h4 class="font-bold">
        Team Members
      </h4>
    </div>
    <div class="flex flex-row gap-2">
      <AvatarLink
        :href="detail.owner.profile_url"
        :image-url="detail.owner.image_url" :name="detail.owner.name" />
      <AvatarLink
        v-for="(member, index ) in detail.members" :key="index" :href="member.profile_url"
        :image-url="member.image_url" :name="member.name" />
    </div>
  </div>
</template>
<style scoped>

</style>
