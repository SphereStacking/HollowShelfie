<script setup>
import { ref } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import ActionMessage from '@/Jetstream/ActionMessage.vue'
import FormSection from '@/Jetstream/FormSection.vue'
import InputError from '@/Jetstream/InputError.vue'
import InputLabel from '@/Jetstream/InputLabel.vue'
import PrimaryButton from '@/Jetstream/PrimaryButton.vue'
import SecondaryButton from '@/Jetstream/SecondaryButton.vue'
import TextInput from '@/Jetstream/TextInput.vue'

const props = defineProps({
  user: Object,
})

const form = useForm({
  _method: 'PUT',
  name: props.user.name,
  email: props.user.email,
  photo: null,
  screen_name: props.user.screen_name,
})

const verificationLinkSent = ref(null)
const photoPreview = ref(null)
const photoInput = ref(null)

const updateProfileInformation = () => {
  if (photoInput.value) {
    form.photo = photoInput.value.files[0]
  }

  form.post(route('user-profile-information.update'), {
    errorBag: 'updateProfileInformation',
    preserveScroll: true,
    onSuccess: () => clearPhotoFileInput(),
  })
}

const sendEmailVerification = () => {
  verificationLinkSent.value = true
}

const selectNewPhoto = () => {
  photoInput.value.click()
}

const updatePhotoPreview = () => {
  const photo = photoInput.value.files[0]

  if (! photo) return

  const reader = new FileReader()

  reader.onload = (e) => {
    photoPreview.value = e.target.result
  }

  reader.readAsDataURL(photo)
}

const deletePhoto = () => {
  router.delete(route('current-user-photo.destroy'), {
    preserveScroll: true,
    onSuccess: () => {
      photoPreview.value = null
      clearPhotoFileInput()
    },
  })
}

const clearPhotoFileInput = () => {
  if (photoInput.value?.value) {
    photoInput.value.value = null
  }
}
</script>

<template>
  <FormSection @submitted="updateProfileInformation">
    <template #title>
      {{ $t('Profile Information') }}
    </template>

    <template #description>
      {{ $t('Update your account\'s profile information and email address.') }}
    </template>

    <template #form>
      <!-- Profile Photo -->
      <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
        <!-- Profile Photo File Input -->
        <input
          ref="photoInput"
          type="file"
          class="hidden"
          @change="updatePhotoPreview">

        <InputLabel for="photo" :value="$t('Photo')" />

        <!-- Current Profile Photo -->
        <div v-show="! photoPreview" class="mt-2">
          <img :src="user.profile_photo_url" :alt="user.name" class="h-20 w-20 rounded-full object-cover">
        </div>

        <!-- New Profile Photo Preview -->
        <div v-show="photoPreview" class="mt-2">
          <span
            class="block h-20 w-20 rounded-full bg-cover bg-center bg-no-repeat"
            :style="'background-image: url(\'' + photoPreview + '\');'"></span>
        </div>

        <SecondaryButton class="mr-2 mt-2" type="button" @click.prevent="selectNewPhoto">
          {{ $t('Select A New Photo') }}
        </SecondaryButton>

        <SecondaryButton
          v-if="user.profile_photo_path"
          type="button"
          class="mt-2"
          @click.prevent="deletePhoto">
          {{ $t('Remove Photo') }}
        </SecondaryButton>

        <InputError :message="form.errors.photo" class="mt-2" />
      </div>

      <!-- User Id -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="user_id" :value="$t('User ID')" />
        <TextInput
          id="user_id"
          v-model="form.screen_name"
          type="text"
          class="mt-1 block w-full"
          required
          autocomplete="id" />
        <InputError :message="form.errors.screen_name" class="mt-2" />
      </div>

      <!-- Name -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" :value="$t('Name')" />
        <TextInput
          id="name"
          v-model="form.name"
          type="text"
          class="mt-1 block w-full"
          required
          autocomplete="name" />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="email" :value="$t('Email')" />
        <TextInput
          id="email"
          v-model="form.email"
          type="email"
          class="mt-1 block w-full"
          required
          autocomplete="username" />
        <InputError :message="form.errors.email" class="mt-2" />

        <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
          <p class="mt-2 text-sm">
            {{ $t('Your email address is unverified.') }}

            <Link
              :href="route('verification.send')"
              method="post"
              as="button"
              class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
              @click.prevent="sendEmailVerification">
              {{ $t('Click here to re-send the verification email.') }}
            </Link>
          </p>

          <div v-show="verificationLinkSent" class="mt-2 text-sm font-medium text-success">
            {{ $t('A new verification link has been sent to your email address.') }}
          </div>
        </div>
      </div>
    </template>

    <template #actions>
      <ActionMessage :on="form.recentlySuccessful" class="mr-3">
        {{ $t('Saved.') }}
      </ActionMessage>

      <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        {{ $t('Save') }}
      </PrimaryButton>
    </template>
  </FormSection>
</template>
