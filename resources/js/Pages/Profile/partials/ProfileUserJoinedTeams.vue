<script setup>
import { usePage } from '@inertiajs/vue3'
const page = usePage()
const type = ref(page.props.profile.type)
const isUserProfile = computed(() => {
  return type.value === 'user'
})

const props = defineProps({
  joinedTeams: {
    type: Array,
    required: true,
  },
})

const hasJoinedTeams = computed(() => {
  return props.joinedTeams.length > 0
})

</script>
<template>
  <div v-if="isUserProfile && hasJoinedTeams">
    <div class="divider divider-end mt-5 w-full text-2xl font-bold">
      <div>
        <IconTypeMapper type="team" />
      </div>
      <h4 class="font-bold">
        Joined Teams
      </h4>
    </div>
    <div class="flex flex-row gap-2">
      <div v-for="(team, index) in joinedTeams" :key="index">
        <AvatarLink :href="team.profile_url" :image-url="team.team_logo_url" :name="team.name" />
      </div>
    </div>
  </div>
</template>
<style scoped>

</style>
