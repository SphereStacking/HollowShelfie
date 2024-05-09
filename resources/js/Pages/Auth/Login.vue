<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import AuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import AuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import Checkbox from '@/Jetstream/Checkbox.vue'
import InputError from '@/Jetstream/InputError.vue'
import InputLabel from '@/Jetstream/InputLabel.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'
import TextInput from '@/Jetstream/TextInput.vue'
import Socialstream from '@/Components/Socialstream.vue'

defineProps({
  canResetPassword: Boolean,
  status: String,
})

const form = useForm({
  _token: usePage().props.csrf_token,
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  onAnimate()
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}

const animationGhost = ref(null)
const onAnimate = () => {
  if (animationGhost.value) {
    animationGhost.value.animationStart()
  }
}
</script>

<template>
  <Head :title="$t('Log in')" />

  <AnimationGhost ref="animationGhost" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo class=" size-20 " />
    </template>
    <div v-if="status" class="mb-4 text-sm font-medium text-success">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" :value="$t('Email')" />
        <TextInput
          id="email" v-model="form.email" type="email"
          class="mt-1 block w-full" required autofocus
          autocomplete="username" />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" :value="$t('Password')" />
        <TextInput
          id="password" v-model="form.password" type="password"
          class="mt-1 block w-full" required
          autocomplete="current-password" />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4 block">
        <label class="flex items-center">
          <Checkbox v-model:checked="form.remember" name="remember" />
          <span class="ml-2 text-sm ">{{ $t('Remember me') }}</span>
        </label>
      </div>

      <div class="mt-4 flex items-center justify-end">
        <Link v-if="canResetPassword" :href="route('password.request')" class="link">
          {{ $t('Forgot your password?') }}
        </Link>

        <PrimaryButton
          class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          {{ $t('Log in') }}
        </PrimaryButton>
      </div>
    </form>
    <Socialstream
      v-if="$page.props.socialstream.show && $page.props.socialstream.providers.length"
      :error="$page.props.errors.socialstream" :prompt="$page.props.socialstream.prompt"
      :labels="$page.props.socialstream.labels" :providers="$page.props.socialstream.providers" />
    <div class="mt-2 flex flex-col justify-center">
      <div class="mt-2">
        {{ $t('Not a member?') }}
        <Link :href="route('register')" class="link">
          {{ $t('Sign up') }}
        </Link>
      </div>
    </div>
  </AuthenticationCard>
</template>
