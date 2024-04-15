<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import AuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import Checkbox from '@/Jetstream/Checkbox.vue'
import InputError from '@/Jetstream/InputError.vue'
import InputLabel from '@/Jetstream/InputLabel.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'
import TextInput from '@/Jetstream/TextInput.vue'
import Socialstream from '@/Components/Socialstream.vue'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false,
})

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <Head :title="$t('Register')" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="name" :value="$t('Name')" />
        <TextInput
          id="name" v-model="form.name" type="text"
          class="mt-1 block w-full" required autofocus
          autocomplete="name" />
        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="mt-4">
        <InputLabel for="email" :value="$t('Email')" />
        <TextInput
          id="email" v-model="form.email" type="email"
          class="mt-1 block w-full" required
          autocomplete="username" />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" :value="$t('Password')" />
        <TextInput
          id="password" v-model="form.password" type="password"
          class="mt-1 block w-full" required
          autocomplete="new-password" />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4">
        <InputLabel for="password_confirmation" :value="$t('Confirm Password')" />
        <TextInput
          id="password_confirmation" v-model="form.password_confirmation" type="password"
          class="mt-1 block w-full" required autocomplete="new-password" />
        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>

      <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
        <InputLabel for="terms">
          <div class="flex items-center">
            <Checkbox
              id="terms" v-model:checked="form.terms" name="terms"
              required />

            <div class="ml-2">
              {{ $t('I agree to') }}
              (
              <a
                target="_blank" :href="route('legal', 'terms-of-service')"
                class="rounded-md text-sm  text-base-content underline">
                {{ $t('Terms of Service') }}
              </a>
              &nbsp;
              <a target="_blank" :href="route('legal', 'privacy-policy')" class="rounded-md text-sm  text-base-content underline">
                {{ $t('Privacy Policy') }}
              </a>
              )
            </div>
          </div>
          <InputError class="mt-2" :message="form.errors.terms" />
        </InputLabel>
      </div>

      <div class="mt-4 flex items-center justify-end">
        <Link
          :href="route('login')"
          class="rounded-md text-sm  underline focus:outline-none focus:ring-2 focus:ring-offset-2 ">
          {{ $t('Already registered?') }}
        </Link>

        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          {{ $t('Register') }}
        </PrimaryButton>
      </div>
    </form>

    <Socialstream
      v-if="$page.props.socialstream.show && $page.props.socialstream.providers.length"
      :error="$page.props.errors.socialstream" :prompt="$page.props.socialstream.prompt"
      :labels="$page.props.socialstream.labels" :providers="$page.props.socialstream.providers" />
    <div class="mt-2 flex flex-col justify-center">
      <div class="mt-2">
        {{ $t('Already registered?') }}
        <Link :href="route('login')" class="link">
          {{ $t('Log in') }}
        </Link>
      </div>
    </div>
  </AuthenticationCard>
</template>
