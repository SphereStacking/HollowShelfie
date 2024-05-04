<script setup>
import {ref} from 'vue'
import {useForm, usePage} from '@inertiajs/vue3'
import ActionSection from '@/Jetstream/ActionSection.vue'
import ConnectedAccount from '@/Components/ConnectedAccount.vue'
import DangerButton from '@/Jetstream/DangerButton.vue'
import DialogModal from '@/Jetstream/DialogModal.vue'
import InputError from '@/Jetstream/InputError.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'
import SecondaryButton from '@/Jetstream/SecondaryButton.vue'
import TextInput from '@/Jetstream/TextInput.vue'

const accountId = ref(null)
const confirmingRemoveAccount = ref(false)
const passwordInput = ref(null)

const page= usePage()

const form = useForm({
  password: '',
})

const getAccountForProvider = (provider) => page.props.socialstream.connectedAccounts
  .filter(account => account.provider === provider.id)
  .shift()

const setProfilePhoto = (id) => {
  form.put(route('user-profile-photo.set', { id }), {
    preserveScroll: true
  })
}

const confirmRemoveAccount = (id) => {
  accountId.value = id

  confirmingRemoveAccount.value = true

  setTimeout(() => passwordInput.value.focus(), 250)
}

const removeAccount = () => {
  form.delete(route('connected-accounts.destroy', { id: accountId.value }), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  })
}

const closeModal = () => {
  confirmingRemoveAccount.value = false

  form.reset()
}

</script>

<template>
  <ActionSection>
    <template #title>
      {{ $t('Connected Accounts') }}
    </template>

    <template #description>
      {{ $t('Connect your social media accounts to enable Sign In with OAuth.') }}
    </template>

    <template #content>
      <div class="rounded border-l-4 border-error bg-error/10 p-4 text-sm font-medium">
        {{ $t('If you feel any of your connected accounts have been compromised, you should disconnect them immediately and change your password.') }}
      </div>

      <div class="mt-6 space-y-6">
        <div v-for="(provider) in $page.props.socialstream.providers" :key="provider">
          <ConnectedAccount
            :provider="provider"
            :created-at="getAccountForProvider(provider)?.created_at">
            <template #action>
              <template v-if="getAccountForProvider(provider)">
                <div class="flex items-center space-x-6">
                  <button
                    v-if="$page.props.jetstream.managesProfilePhotos && getAccountForProvider(provider).avatar_path"
                    class="btn btn-ghost btn-sm"
                    @click="setProfilePhoto(getAccountForProvider(provider).id)">
                    {{ $t('Use Avatar as Profile Photo') }}
                  </button>

                  <DangerButton
                    v-if="$page.props.socialstream.connectedAccounts.length > 1 || $page.props.socialstream.hasPassword"
                    @click="confirmRemoveAccount(getAccountForProvider(provider).id)">
                    {{ $t('Disconnect') }}
                  </DangerButton>
                </div>
              </template>

              <template v-else>
                <Link class="btn btn-outline btn-sm" :href="route('oauth.redirect', { provider })">
                  {{ $t('Connect') }}
                </Link>
              </template>
            </template>
          </ConnectedAccount>
        </div>
      </div>

      <!-- Confirmation Modal -->
      <DialogModal :show="confirmingRemoveAccount" @close="closeModal">
        <template #title>
          {{ $t('Are you sure you want to disconnect this account?') }}
        </template>

        <template #content>
          {{ $t('Please enter your password to confirm you would like to remove this account.') }}

          <div class="mt-4">
            <TextInput
              ref="passwordInput"
              v-model="form.password"
              type="password"
              class="mt-1 block w-3/4"
              placeholder="Password"
              autocomplete="current-password"
              @keyup.enter="removeAccount" />

            <InputError :message="form.errors.password" class="mt-2" />
          </div>
        </template>

        <template #footer>
          <SecondaryButton @click="closeModal">
            {{ $t('Cancel') }}
          </SecondaryButton>

          <PrimaryButton
            class="ml-2" :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing" @click="removeAccount">
            {{ $t('Disconnect') }}
          </PrimaryButton>
        </template>
      </DialogModal>
    </template>
  </ActionSection>
</template>
