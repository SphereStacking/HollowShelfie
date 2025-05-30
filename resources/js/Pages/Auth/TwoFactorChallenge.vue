<script setup>
import { nextTick, ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import AuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import InputError from '@/Jetstream/InputError.vue'
import InputLabel from '@/Jetstream/InputLabel.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'
import TextInput from '@/Jetstream/TextInput.vue'

const recovery = ref(false)

const form = useForm({
  code: '',
  recovery_code: '',
})

const recoveryCodeInput = ref(null)
const codeInput = ref(null)

const toggleRecovery = async () => {
  recovery.value ^= true

  await nextTick()

  if (recovery.value) {
    recoveryCodeInput.value.focus()
    form.code = ''
  } else {
    codeInput.value.focus()
    form.recovery_code = ''
  }
}

const submit = () => {
  form.post(route('two-factor.login'))
}
</script>

<template>
  <Head :title="$t('Two-factor Confirmation')" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <div class="mb-4 text-sm text-base-content">
      <template v-if="! recovery">
        {{ $t('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
      </template>

      <template v-else>
        {{ $t('Please confirm access to your account by entering one of your emergency recovery codes.') }}
      </template>
    </div>

    <form @submit.prevent="submit">
      <div v-if="! recovery">
        <InputLabel for="code" :value="$t('Code')" />
        <TextInput
          id="code"
          ref="codeInput"
          v-model="form.code"
          type="text"
          inputmode="numeric"
          class="mt-1 block w-full"
          autofocus
          autocomplete="one-time-code" />
        <InputError class="mt-2" :message="form.errors.code" />
      </div>

      <div v-else>
        <InputLabel for="recovery_code" :value="$t('Recovery Code')" />
        <TextInput
          id="recovery_code"
          ref="recoveryCodeInput"
          v-model="form.recovery_code"
          type="text"
          class="mt-1 block w-full"
          autocomplete="one-time-code" />
        <InputError class="mt-2" :message="form.errors.recovery_code" />
      </div>

      <div class="mt-4 flex items-center justify-end">
        <button type="button" class="cursor-pointer text-sm text-base-content underline" @click.prevent="toggleRecovery">
          <template v-if="! recovery">
            {{ $t('Use a recovery code') }}
          </template>

          <template v-else>
            {{ $t('Use an authentication code') }}
          </template>
        </button>

        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          {{ $t('Log in') }}
        </PrimaryButton>
      </div>
    </form>
  </AuthenticationCard>
</template>
