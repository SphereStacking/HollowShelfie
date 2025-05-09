<script setup>
import { useForm } from '@inertiajs/vue3'
import ActionMessage from '@/Jetstream/ActionMessage.vue'
import FormSection from '@/Jetstream/FormSection.vue'
import InputError from '@/Jetstream/InputError.vue'
import InputLabel from '@/Jetstream/InputLabel.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'
import TextInput from '@/Jetstream/TextInput.vue'

const props = defineProps({
  team: Object,
  permissions: Object,
})

const form = useForm({
  name: props.team.name,
})

const updateTeamName = () => {
  form.put(route('teams.update', props.team.screen_name.screen_name), {
    errorBag: 'updateTeamName',
    preserveScroll: true,
  })
}
</script>

<template>
  <FormSection @submitted="updateTeamName">
    <template #title>
      {{ $t('Team Name') }}
    </template>

    <template #description>
      {{ $t('The team\'s name and owner information.') }}
    </template>

    <template #form>
      <!-- Team Owner Information -->
      <div class="col-span-6">
        <InputLabel :value="$t('Team Owner')" />

        <div class="mt-2 flex items-center">
          <img class="size-12 rounded-full object-cover" :src="team.owner.profile_photo_url" :alt="team.owner.name">

          <div class="ml-4 leading-tight">
            <div class="text-base-content">
              {{ team.owner.name }}
            </div>
            <div class="text-sm text-base-content">
              {{ team.owner.email }}
            </div>
          </div>
        </div>
      </div>

      <!-- Team Name -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" :value="$t('Team Name')" />

        <TextInput
          id="name" v-model="form.name" type="text"
          class="mt-1 block w-full"
          :disabled="!permissions.canUpdateTeam" />

        <InputError :message="form.errors.name" class="mt-2" />
      </div>
    </template>

    <template v-if="permissions.canUpdateTeam" #actions>
      <ActionMessage :on="form.recentlySuccessful" class="mr-3">
        Saved.
      </ActionMessage>

      <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Save
      </PrimaryButton>
    </template>
  </FormSection>
</template>
