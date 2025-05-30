<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import AuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import InputError from '@/Jetstream/InputError.vue'
import InputLabel from '@/Jetstream/InputLabel.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'
import TextInput from '@/Jetstream/TextInput.vue'

const props = defineProps({
  email: String,
  token: String,
})

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('password.update'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <Head :title="$t('Reset Password')" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" :value="$t('Email')" />
        <TextInput
          id="email"
          v-model="form.email"
          type="email"
          class="mt-1 block w-full"
          required
          autofocus
          autocomplete="username" />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" :value="$t('Password')" />
        <TextInput
          id="password"
          v-model="form.password"
          type="password"
          class="mt-1 block w-full"
          required
          autocomplete="new-password" />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4">
        <InputLabel for="password_confirmation" :value="$t('Confirm Password')" />
        <TextInput
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          class="mt-1 block w-full"
          required
          autocomplete="new-password" />
        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>

      <div class="mt-4 flex items-center justify-end">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          {{ $t('Reset Password') }}
        </PrimaryButton>
      </div>
    </form>
  </AuthenticationCard>
</template>
