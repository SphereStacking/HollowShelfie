<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import ActionSection from '@/Jetstream/ActionSection.vue'
import DangerButton from '@/Jetstream/DangerButton.vue'
import DialogModal from '@/Jetstream/DialogModal.vue'
import InputError from '@/Jetstream/InputError.vue'
import SecondaryButton from '@/Jetstream/SecondaryButton.vue'
import TextInput from '@/Jetstream/TextInput.vue'

const confirmingUserDeletion = ref(false)
const passwordInput = ref(null)

const form = useForm({
  password: '',
})

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true

  setTimeout(() => passwordInput.value.focus(), 250)
}

const deleteUser = () => {
  form.delete(route('current-user.destroy'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  })
}

const closeModal = () => {
  confirmingUserDeletion.value = false

  form.reset()
}
</script>

<template>
  <ActionSection>
    <template #title>
      {{ $t('Delete Account') }}
    </template>

    <template #description>
      {{ $t('Permanently delete your account.') }}
    </template>

    <template #content>
      <div class="max-w-xl text-sm ">
        {{ $t('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
      </div>

      <div class="mt-5">
        <DangerButton @click="confirmUserDeletion">
          {{ $t('Delete Account') }}
        </DangerButton>
      </div>

      <!-- Delete Account Confirmation Modal -->
      <DialogModal :show="confirmingUserDeletion" @close="closeModal">
        <template #title>
          {{ $t('Delete Account') }}
        </template>

        <template #content>
          {{ $t('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

          <div class="mt-4">
            <TextInput
              ref="passwordInput" v-model="form.password" type="password"
              class="mt-1 block w-3/4"
              placeholder="Password" autocomplete="current-password" @keyup.enter="deleteUser" />

            <InputError :message="form.errors.password" class="mt-2" />
          </div>
        </template>

        <template #footer>
          <SecondaryButton @click="closeModal">
            {{ $t('Cancel') }}
          </SecondaryButton>

          <DangerButton
            class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="deleteUser">
            {{ $t('Delete Account') }}
          </DangerButton>
        </template>
      </DialogModal>
    </template>
  </ActionSection>
</template>
