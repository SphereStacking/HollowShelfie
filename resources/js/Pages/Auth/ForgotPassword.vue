<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import AuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import InputError from '@/Jetstream/InputError.vue'
import InputLabel from '@/Jetstream/InputLabel.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'
import TextInput from '@/Jetstream/TextInput.vue'

defineProps({
  status: String,
})

const form = useForm({
  email: '',
})

const submit = () => {
  form.post(route('password.email'))
}
</script>

<template>
  <Head :title="$t('Forgot Password')" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <div class="mb-4 text-sm text-base-content">
      {{ $t('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <div v-if="status" class="mb-4 text-sm font-medium text-success">
      {{ status }}
    </div>

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

      <div class="mt-4 flex items-center justify-end">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          {{ $t('Email Password Reset Link') }}
        </PrimaryButton>
      </div>
    </form>
  </AuthenticationCard>
</template>
