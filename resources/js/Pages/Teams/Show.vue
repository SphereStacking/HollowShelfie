<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import DeleteTeamForm from '@/Pages/Teams/Partials/DeleteTeamForm.vue'
import SectionBorder from '@/Jetstream/SectionBorder.vue'
import TeamMemberManager from '@/Pages/Teams/Partials/TeamMemberManager.vue'
import UpdateTeamNameForm from '@/Pages/Teams/Partials/UpdateTeamNameForm.vue'

defineProps({
  team: Object,
  availableRoles: Array,
  permissions: Object,
})
</script>

<template>
  <AppLayout :title="$t('Team Settings')">
    <template #header>
      <h2 class="text-xl font-semibold  leading-tight">
        Team Settings
      </h2>
    </template>

    <div>
      <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
        <UpdateTeamLogoForm :team="team" :permissions="permissions" />
        <SectionBorder />
        <UpdateTeamScreenNameForm :team="team" :permissions="permissions" />

        <SectionBorder />
        <UpdateTeamNameForm :team="team" :permissions="permissions" />

        <TeamMemberManager
          class="mt-10 sm:mt-0" :team="team" :available-roles="availableRoles"
          :user-permissions="permissions" />

        <template v-if="permissions.canDeleteTeam && !team.personal_team">
          <SectionBorder />

          <DeleteTeamForm class="mt-10 sm:mt-0" :team="team" />
        </template>
      </div>
    </div>
  </AppLayout>
</template>
