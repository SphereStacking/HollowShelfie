<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import ActionMessage from '@/Jetstream/ActionMessage.vue'
import ActionSection from '@/Jetstream/ActionSection.vue'
import Checkbox from '@/Jetstream/Checkbox.vue'
import ConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import DangerButton from '@/Jetstream/DangerButton.vue'
import DialogModal from '@/Jetstream/DialogModal.vue'
import FormSection from '@/Jetstream/FormSection.vue'
import InputError from '@/Jetstream/InputError.vue'
import InputLabel from '@/Jetstream/InputLabel.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'
import SecondaryButton from '@/Jetstream/SecondaryButton.vue'
import SectionBorder from '@/Jetstream/SectionBorder.vue'
import TextInput from '@/Jetstream/TextInput.vue'

const props = defineProps({
  tokens: Array,
  availablePermissions: Array,
  defaultPermissions: Array,
})

const createApiTokenForm = useForm({
  name: '',
  permissions: props.defaultPermissions,
})

const updateApiTokenForm = useForm({
  permissions: [],
})

const deleteApiTokenForm = useForm({})

const displayingToken = ref(false)
const managingPermissionsFor = ref(null)
const apiTokenBeingDeleted = ref(null)

const createApiToken = () => {
  createApiTokenForm.post(route('api-tokens.store'), {
    preserveScroll: true,
    onSuccess: () => {
      displayingToken.value = true
      createApiTokenForm.reset()
    },
  })
}

const manageApiTokenPermissions = (token) => {
  updateApiTokenForm.permissions = token.abilities
  managingPermissionsFor.value = token
}

const updateApiToken = () => {
  updateApiTokenForm.put(route('api-tokens.update', managingPermissionsFor.value), {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => managingPermissionsFor.value = null,
  })
}

const confirmApiTokenDeletion = (token) => {
  apiTokenBeingDeleted.value = token
}

const deleteApiToken = () => {
  deleteApiTokenForm.delete(route('api-tokens.destroy', apiTokenBeingDeleted.value), {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => apiTokenBeingDeleted.value = null,
  })
}
</script>

<template>
  <div>
    <!-- Generate API Token -->
    <FormSection @submitted="createApiToken">
      <template #title>
        {{ $t('Create API Token') }}
      </template>

      <template #description>
        {{ $t('API tokens allow third-party services to authenticate with our application on your behalf.') }}
      </template>

      <template #form>
        <!-- Token Name -->
        <div class="col-span-6 sm:col-span-4">
          <InputLabel for="name" :value="$t('Name')" />
          <TextInput
            id="name"
            v-model="createApiTokenForm.name"
            type="text"
            class="mt-1 block w-full"
            autofocus />
          <InputError :message="createApiTokenForm.errors.name" class="mt-2" />
        </div>

        <!-- Token Permissions -->
        <div v-if="availablePermissions.length > 0" class="col-span-6">
          <InputLabel for="permissions" :value="$t('Permissions')" />

          <div class="mt-2 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div v-for="permission in availablePermissions" :key="permission">
              <label class="flex items-center">
                <Checkbox v-model:checked="createApiTokenForm.permissions" :value="permission" />
                <span class="ml-2 text-sm text-base-content">{{ permission }}</span>
              </label>
            </div>
          </div>
        </div>
      </template>

      <template #actions>
        <ActionMessage :on="createApiTokenForm.recentlySuccessful" class="mr-3">
          {{ $t('Created.') }}
        </ActionMessage>

        <PrimaryButton :class="{ 'opacity-25': createApiTokenForm.processing }" :disabled="createApiTokenForm.processing">
          {{ $t('Create') }}
        </PrimaryButton>
      </template>
    </FormSection>

    <div v-if="tokens.length > 0">
      <SectionBorder />

      <!-- Manage API Tokens -->
      <div class="mt-10 sm:mt-0">
        <ActionSection>
          <template #title>
            {{ $t('Manage API Tokens') }}
          </template>

          <template #description>
            {{ $t('You may delete any of your existing tokens if they are no longer needed.') }}
          </template>

          <!-- API Token List -->
          <template #content>
            <div class="space-y-6">
              <div v-for="token in tokens" :key="token.id" class="flex items-center justify-between">
                <div class="break-all">
                  {{ token.name }}
                </div>

                <div class="ml-2 flex items-center">
                  <div v-if="token.last_used_ago" class="text-sm text-base-content">
                    {{ $t('Last used') }} {{ token.last_used_ago }}
                  </div>

                  <button
                    v-if="availablePermissions.length > 0"
                    class="ml-6 cursor-pointer text-sm text-base-content underline"
                    @click="manageApiTokenPermissions(token)">
                    {{ $t('Permissions') }}
                  </button>

                  <button class="ml-6 cursor-pointer text-sm text-error" @click="confirmApiTokenDeletion(token)">
                    {{ $t('Delete') }}
                  </button>
                </div>
              </div>
            </div>
          </template>
        </ActionSection>
      </div>
    </div>

    <!-- Token Value Modal -->
    <DialogModal :show="displayingToken" @close="displayingToken = false">
      <template #title>
        {{ $t('API Token') }}
      </template>

      <template #content>
        <div>
          {{ $t('Please copy your new API token. For your security, it won\'t be shown again.') }}
        </div>

        <div v-if="$page.props.jetstream.flash.token" class="mt-4 break-all rounded bg-gray-100 px-4 py-2 font-mono text-sm text-base-content">
          {{ $page.props.jetstream.flash.token }}
        </div>
      </template>

      <template #footer>
        <SecondaryButton @click="displayingToken = false">
          {{ $t('Close') }}
        </SecondaryButton>
      </template>
    </DialogModal>

    <!-- API Token Permissions Modal -->
    <DialogModal :show="managingPermissionsFor != null" @close="managingPermissionsFor = null">
      <template #title>
        {{ $t('API Token Permissions') }}
      </template>

      <template #content>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div v-for="permission in availablePermissions" :key="permission">
            <label class="flex items-center">
              <Checkbox v-model:checked="updateApiTokenForm.permissions" :value="permission" />
              <span class="ml-2 text-sm text-base-content">{{ permission }}</span>
            </label>
          </div>
        </div>
      </template>

      <template #footer>
        <SecondaryButton @click="managingPermissionsFor = null">
          {{ $t('Cancel') }}
        </SecondaryButton>

        <PrimaryButton
          class="ml-3"
          :class="{ 'opacity-25': updateApiTokenForm.processing }"
          :disabled="updateApiTokenForm.processing"
          @click="updateApiToken">
          {{ $t('Save') }}
        </PrimaryButton>
      </template>
    </DialogModal>

    <!-- Delete Token Confirmation Modal -->
    <ConfirmationModal :show="apiTokenBeingDeleted != null" @close="apiTokenBeingDeleted = null">
      <template #title>
        {{ $t('Delete API Token') }}
      </template>

      <template #content>
        {{ $t('Are you sure you would like to delete this API token?') }}
      </template>

      <template #footer>
        <SecondaryButton @click="apiTokenBeingDeleted = null">
          {{ $t('Cancel') }}
        </SecondaryButton>

        <DangerButton
          class="ml-3"
          :class="{ 'opacity-25': deleteApiTokenForm.processing }"
          :disabled="deleteApiTokenForm.processing"
          @click="deleteApiToken">
          {{ $t('Delete') }}
        </DangerButton>
      </template>
    </ConfirmationModal>
  </div>
</template>
