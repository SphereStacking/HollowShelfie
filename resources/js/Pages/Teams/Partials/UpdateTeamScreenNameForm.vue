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
  screen_name: props.team.screen_name.screen_name,
})

const updateTeamScreenName = () => {
  form.put(route('screen_name.update', props.team.screen_name.screen_name), {
    errorBag: 'updateTeamScreenName',
    preserveScroll: true,
  })
}
</script>

<template>
  <FormSection @submitted="updateTeamScreenName">
    <template #title>
      {{ $t('Team ID') }}
    </template>

    <template #description>
      {{ $t('The team\'s ID.') }}
    </template>

    <template #form>
      <!-- Team Screen Name -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="screen_name" :value="$t('Team ID')" />

        <TextInput
          id="screen_name" v-model="form.screen_name" type="text"
          class="mt-1 block w-full"
          :disabled="!permissions.canUpdateTeam" />

        <InputError :message="form.errors.screen_name" class="mt-2" />
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
