<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import Checkbox from '@/Jetstream/Checkbox.vue';
import InputError from '@/Jetstream/InputError.vue';
import InputLabel from '@/Jetstream/InputLabel.vue';
import PrimaryButton from '@/Jetstream/PrimaryButton.vue';
import TextInput from '@/Jetstream/TextInput.vue';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Log in" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" />
        <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required autofocus
          autocomplete="username" />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />
        <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
          autocomplete="current-password" />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="block mt-4">
        <label class="flex items-center">
          <Checkbox v-model:checked="form.remember" name="remember" />
          <span class="ml-2 text-sm ">Remember me</span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link v-if="canResetPassword" :href="route('password.request')" class="link">
        Forgot your password?
        </Link>

        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Log in
        </PrimaryButton>
      </div>
    </form>
    <div class="mt-2 flex justify-center flex-col">
      <div class="divider">OR</div>
      <SocialLogin></SocialLogin>
      <div class="mt-2">Not a member?
        <Link :href="route('register')" class="link"> Sign up</Link>
      </div>
    </div>
  </AuthenticationCard>
</template>
