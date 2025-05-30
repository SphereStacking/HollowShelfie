<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import ActionSection from '@/Jetstream/ActionSection.vue'
import ConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import DangerButton from '@/Jetstream/DangerButton.vue'
import SecondaryButton from '@/Jetstream/SecondaryButton.vue'

const props = defineProps({
  team: Object,
})

const confirmingTeamDeletion = ref(false)
const form = useForm({})

const confirmTeamDeletion = () => {
  confirmingTeamDeletion.value = true
}

const deleteTeam = () => {
  form.delete(route('teams.destroy', props.team.screen_name.screen_name), {
    errorBag: 'deleteTeam',
  })
}
</script>

<template>
  <ActionSection>
    <template #title>
      {{ $t('Delete Team') }}
    </template>

    <template #description>
      {{ $t('Permanently delete this team.') }}
    </template>

    <template #content>
      <div class="max-w-xl text-sm text-base-content">
        {{ $t('Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.') }}
      </div>

      <div class="mt-5">
        <DangerButton @click="confirmTeamDeletion">
          {{ $t('Delete Team') }}
        </DangerButton>
      </div>

      <!-- Delete Team Confirmation Modal -->
      <ConfirmationModal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
        <template #title>
          {{ $t('Delete Team') }}
        </template>

        <template #content>
          {{ $t('Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.') }}
        </template>

        <template #footer>
          <SecondaryButton @click="confirmingTeamDeletion = false">
            {{ $t('Cancel') }}
          </SecondaryButton>

          <DangerButton
            class="ml-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="deleteTeam">
            {{ $t('Delete Team') }}
          </DangerButton>
        </template>
      </ConfirmationModal>
    </template>
  </ActionSection>
</template>
