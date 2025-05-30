<script setup>
import { ref } from 'vue'
import { router, useForm, usePage } from '@inertiajs/vue3'
import ActionMessage from '@/Jetstream/ActionMessage.vue'
import ActionSection from '@/Jetstream/ActionSection.vue'
import ConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import DangerButton from '@/Jetstream/DangerButton.vue'
import DialogModal from '@/Jetstream/DialogModal.vue'
import FormSection from '@/Jetstream/FormSection.vue'
import InputError from '@/Jetstream/InputError.vue'
import InputLabel from '@/Jetstream/InputLabel.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'
import SecondaryButton from '@/Jetstream/SecondaryButton.vue'
import SectionBorder from '@/Jetstream/SectionBorder.vue'
import TextInput from '@/Jetstream/TextInput.vue'

const props = defineProps({
  team: Object,
  availableRoles: Array,
  userPermissions: Object,
})

const page = usePage()

const addTeamMemberForm = useForm({
  email: '',
  role: null,
})

const updateRoleForm = useForm({
  role: null,
})

const leaveTeamForm = useForm({})
const removeTeamMemberForm = useForm({})

const currentlyManagingRole = ref(false)
const managingRoleFor = ref(null)
const confirmingLeavingTeam = ref(false)
const teamMemberBeingRemoved = ref(null)

const addTeamMember = () => {
  addTeamMemberForm.post(route('team-members.store', props.team.screen_name.screen_name), {
    errorBag: 'addTeamMember',
    preserveScroll: true,
    onSuccess: () => addTeamMemberForm.reset(),
  })
}

const cancelTeamInvitation = (invitation) => {
  router.delete(route('team-invitations.destroy', invitation), {
    preserveScroll: true,
  })
}

const manageRole = (teamMember) => {
  managingRoleFor.value = teamMember
  updateRoleForm.role = teamMember.membership.role
  currentlyManagingRole.value = true
}

const updateRole = () => {
  updateRoleForm.put(route('team-members.update', [props.team.screen_name.screen_name, managingRoleFor.value]), {
    preserveScroll: true,
    onSuccess: () => currentlyManagingRole.value = false,
  })
}

const confirmLeavingTeam = () => {
  confirmingLeavingTeam.value = true
}

const leaveTeam = () => {
  leaveTeamForm.delete(route('team-members.destroy', [props.team.screen_name, page.props.auth.user.id]))
}

const confirmTeamMemberRemoval = (teamMember) => {
  teamMemberBeingRemoved.value = teamMember
}

const removeTeamMember = () => {
  removeTeamMemberForm.delete(route('team-members.destroy', [props.team.screen_name, teamMemberBeingRemoved.value]), {
    errorBag: 'removeTeamMember',
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => teamMemberBeingRemoved.value = null,
  })
}

const displayableRole = (role) => {
  return props.availableRoles.find(r => r.key === role).name
}
</script>

<template>
  <div>
    <div v-if="userPermissions.canAddTeamMembers">
      <SectionBorder />

      <!-- Add Team Member -->
      <FormSection @submitted="addTeamMember">
        <template #title>
          {{ $t('Add Team Member') }}
        </template>

        <template #description>
          {{ $t('Add a new team member to your team, allowing them to collaborate with you.') }}
        </template>

        <template #form>
          <div class="col-span-6">
            <div class="max-w-xl text-sm text-base-content">
              {{ $t('Please provide the email address of the person you would like to add to this team.') }}
            </div>
          </div>

          <!-- Member Email -->
          <div class="col-span-6 sm:col-span-4">
            <InputLabel for="email" :value="$t('Email')" />
            <TextInput
              id="email"
              v-model="addTeamMemberForm.email"
              type="email"
              class="mt-1 block w-full" />
            <InputError :message="addTeamMemberForm.errors.email" class="mt-2" />
          </div>

          <!-- Role -->
          <div v-if="availableRoles.length > 0" class="col-span-6 lg:col-span-4">
            <InputLabel for="roles" :value="$t('Role')" />
            <InputError :message="addTeamMemberForm.errors.role" class="mt-2" />

            <div class="relative z-0 mt-1 cursor-pointer rounded-lg border border-gray-200">
              <button
                v-for="(role, i) in availableRoles"
                :key="role.key"
                type="button"
                class="relative inline-flex w-full rounded-lg px-4 py-3 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                :class="{'rounded-t-none border-t border-gray-200 focus:border-none': i > 0, 'rounded-b-none': i != Object.keys(availableRoles).length - 1}"
                @click="addTeamMemberForm.role = role.key">
                <div :class="{'opacity-50': addTeamMemberForm.role && addTeamMemberForm.role != role.key}">
                  <!-- Role Name -->
                  <div class="flex items-center">
                    <div class="text-sm text-base-content" :class="{'font-semibold': addTeamMemberForm.role == role.key}">
                      {{ role.name }}
                    </div>

                    <svg
                      v-if="addTeamMemberForm.role == role.key" class="ml-2 size-5 text-success" xmlns="http://www.w3.org/2000/svg"
                      fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>

                  <!-- Role Description -->
                  <div class="mt-2 text-left text-xs text-base-content">
                    {{ role.description }}
                  </div>
                </div>
              </button>
            </div>
          </div>
        </template>

        <template #actions>
          <ActionMessage :on="addTeamMemberForm.recentlySuccessful" class="mr-3">
            {{ $t('Added.') }}
          </ActionMessage>

          <PrimaryButton :class="{ 'opacity-25': addTeamMemberForm.processing }" :disabled="addTeamMemberForm.processing">
            {{ $t('Add') }}
          </PrimaryButton>
        </template>
      </FormSection>
    </div>

    <div v-if="team.team_invitations.length > 0 && userPermissions.canAddTeamMembers">
      <SectionBorder />

      <!-- Team Member Invitations -->
      <ActionSection class="mt-10 sm:mt-0">
        <template #title>
          {{ $t('Pending Team Invitations') }}
        </template>

        <template #description>
          {{ $t('These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.') }}
        </template>

        <!-- Pending Team Member Invitation List -->
        <template #content>
          <div class="space-y-6">
            <div v-for="invitation in team.team_invitations" :key="invitation.id" class="flex items-center justify-between">
              <div class="text-base-content">
                {{ invitation.email }}
              </div>

              <div class="flex items-center">
                <!-- Cancel Team Invitation -->
                <button
                  v-if="userPermissions.canRemoveTeamMembers"
                  class="ml-6 cursor-pointer text-sm text-error focus:outline-none"
                  @click="cancelTeamInvitation(invitation)">
                  {{ $t('Cancel') }}
                </button>
              </div>
            </div>
          </div>
        </template>
      </ActionSection>
    </div>

    <div v-if="team.users.length > 0">
      <SectionBorder />

      <!-- Manage Team Members -->
      <ActionSection class="mt-10 sm:mt-0">
        <template #title>
          {{ $t('Team Members') }}
        </template>

        <template #description>
          {{ $t('All of the people that are part of this team.') }}
        </template>

        <!-- Team Member List -->
        <template #content>
          <div class="space-y-6">
            <div v-for="user in team.users" :key="user.id" class="flex items-center justify-between">
              <div class="flex items-center">
                <img class="size-8 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name">
                <div class="ml-4">
                  {{ user.name }}
                </div>
              </div>

              <div class="flex items-center">
                <!-- Manage Team Member Role -->
                <button
                  v-if="userPermissions.canUpdateTeamMembers && availableRoles.length"
                  class="ml-2 text-sm text-base-content underline"
                  @click="manageRole(user)">
                  {{ displayableRole(user.membership.role) }}
                </button>

                <div v-else-if="availableRoles.length" class="ml-2 text-sm text-base-content">
                  {{ displayableRole(user.membership.role) }}
                </div>

                <!-- Leave Team -->
                <button
                  v-if="$page.props.auth.user.id === user.id"
                  class="ml-6 cursor-pointer text-sm text-error"
                  @click="confirmLeavingTeam">
                  Leave
                </button>

                <!-- Remove Team Member -->
                <button
                  v-else-if="userPermissions.canRemoveTeamMembers"
                  class="ml-6 cursor-pointer text-sm text-error"
                  @click="confirmTeamMemberRemoval(user)">
                  Remove
                </button>
              </div>
            </div>
          </div>
        </template>
      </ActionSection>
    </div>

    <!-- Role Management Modal -->
    <DialogModal :show="currentlyManagingRole" @close="currentlyManagingRole = false">
      <template #title>
        {{ $t('Manage Role') }}
      </template>

      <template #content>
        <div v-if="managingRoleFor">
          <div class="relative z-0 mt-1 cursor-pointer rounded-lg border border-gray-200">
            <button
              v-for="(role, i) in availableRoles"
              :key="role.key"
              type="button"
              class="relative inline-flex w-full rounded-lg px-4 py-3 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
              :class="{'rounded-t-none border-t border-gray-200 focus:border-none': i > 0, 'rounded-b-none': i !== Object.keys(availableRoles).length - 1}"
              @click="updateRoleForm.role = role.key">
              <div :class="{'opacity-50': updateRoleForm.role && updateRoleForm.role !== role.key}">
                <!-- Role Name -->
                <div class="flex items-center">
                  <div class="text-sm text-base-content" :class="{'font-semibold': updateRoleForm.role === role.key}">
                    {{ role.name }}
                  </div>

                  <svg
                    v-if="updateRoleForm.role == role.key" class="ml-2 size-5 text-success" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>

                <!-- Role Description -->
                <div class="mt-2 text-xs text-base-content">
                  {{ role.description }}
                </div>
              </div>
            </button>
          </div>
        </div>
      </template>

      <template #footer>
        <SecondaryButton @click="currentlyManagingRole = false">
          {{ $t('Cancel') }}
        </SecondaryButton>

        <PrimaryButton
          class="ml-3"
          :class="{ 'opacity-25': updateRoleForm.processing }"
          :disabled="updateRoleForm.processing"
          @click="updateRole">
          {{ $t('Save') }}
        </PrimaryButton>
      </template>
    </DialogModal>

    <!-- Leave Team Confirmation Modal -->
    <ConfirmationModal :show="confirmingLeavingTeam" @close="confirmingLeavingTeam = false">
      <template #title>
        {{ $t('Leave Team') }}
      </template>

      <template #content>
        {{ $t('Are you sure you would like to leave this team?') }}
      </template>

      <template #footer>
        <SecondaryButton @click="confirmingLeavingTeam = false">
          {{ $t('Cancel') }}
        </SecondaryButton>

        <DangerButton
          class="ml-3"
          :class="{ 'opacity-25': leaveTeamForm.processing }"
          :disabled="leaveTeamForm.processing"
          @click="leaveTeam">
          {{ $t('Leave') }}
        </DangerButton>
      </template>
    </ConfirmationModal>

    <!-- Remove Team Member Confirmation Modal -->
    <ConfirmationModal :show="teamMemberBeingRemoved" @close="teamMemberBeingRemoved = null">
      <template #title>
        {{ $t('Remove Team Member') }}
      </template>

      <template #content>
        {{ $t('Are you sure you would like to remove this person from the team?') }}
      </template>

      <template #footer>
        <SecondaryButton @click="teamMemberBeingRemoved = null">
          {{ $t('Cancel') }}
        </SecondaryButton>

        <DangerButton
          class="ml-3"
          :class="{ 'opacity-25': removeTeamMemberForm.processing }"
          :disabled="removeTeamMemberForm.processing"
          @click="removeTeamMember">
          {{ $t('Remove') }}
        </DangerButton>
      </template>
    </ConfirmationModal>
  </div>
</template>
