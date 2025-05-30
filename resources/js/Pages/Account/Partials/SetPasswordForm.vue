<script setup>
import {ref} from 'vue'
import {useForm} from '@inertiajs/vue3'
import ActionMessage from '@/Jetstream/ActionMessage.vue'
import Button from '@/Jetstream/PrimaryButton.vue'
import FormSection from '@/Jetstream/FormSection.vue'
import InputError from '@/Jetstream/InputError.vue'
import InputLabel from '@/Jetstream/InputLabel.vue'
import TextInput from '@/Jetstream/TextInput.vue'

const passwordInput = ref(null)

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

const setPassword = () => {
  form.post(route('user-password.set'), {
    errorBag: 'setPassword',
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.password) {
        form.reset('password', 'password_confirmation')
        passwordInput.value.focus()
      }
    },
  })
}
</script>

<template>
  <FormSection @submitted="setPassword">
    <template #title>
      {{ $t('Set Password') }}
    </template>

    <template #description>
      {{ $t('Ensure your account is using a long, random password to stay secure.') }}
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="password" :value="$t('New Password')" />
        <TextInput
          id="password"
          ref="passwordInput"
          v-model="form.password"
          autocomplete="new-password"
          class="mt-1 block w-full"
          type="password" />
        <InputError :message="form.errors.password" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="password_confirmation" :value="$t('Confirm Password')" />
        <TextInput
          id="password_confirmation"
          v-model="form.password_confirmation"
          autocomplete="new-password"
          class="mt-1 block w-full"
          type="password" />
        <InputError :message="form.errors.password_confirmation" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <ActionMessage :on="form.recentlySuccessful" class="mr-3">
        {{ $t('Saved.') }}
      </ActionMessage>

      <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        {{ $t('Save') }}
      </Button>
    </template>
  </FormSection>
</template>
