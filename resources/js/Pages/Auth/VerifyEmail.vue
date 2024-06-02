<script setup>
import { computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import AuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'

const props = defineProps({
  status: String,
})

const form = useForm({})

const submit = () => {
  form.post(route('verification.send'))
}

const verificationLinkSent = computed(() => props.status === 'verification-link-sent')
</script>

<template>
  <Head :title="$t('Email Verification')" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <div class="mb-4 text-sm text-base-content">
      {{ $t("Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
    </div>

    <div v-if="verificationLinkSent" class="mb-4 text-sm font-medium text-success">
      {{ $t('A new verification link has been sent to the email address you provided in your profile settings.') }}
    </div>

    <form @submit.prevent="submit">
      <div class="mt-4 flex items-center justify-between">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          {{ $t('Resend Verification Email') }}
        </PrimaryButton>

        <div>
          <Link
            :href="route('account.show')"
            class="rounded-md text-sm text-base-content underline ">
            {{ $t('Edit Profile') }}
          </Link>

          <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="ml-2 rounded-md text-sm text-base-content underline ">
            {{ $t('Log Out') }}
          </Link>
        </div>
      </div>
    </form>
  </AuthenticationCard>
</template>
