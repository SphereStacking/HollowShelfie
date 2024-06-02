<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import DeleteUserForm from '@/Pages/Account/Partials/DeleteUserForm.vue'
import LogoutOtherBrowserSessionsForm from '@/Pages/Account/Partials/LogoutOtherBrowserSessionsForm.vue'
import SectionBorder from '@/Jetstream/SectionBorder.vue'
import TwoFactorAuthenticationForm from '@/Pages/Account/Partials/TwoFactorAuthenticationForm.vue'
import UpdatePasswordForm from '@/Pages/Account/Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from '@/Pages/Account/Partials/UpdateProfileInformationForm.vue'
import ConnectedAccountsForm from '@/Pages/Account/Partials/ConnectedAccountsForm.vue'
import SetPasswordForm from '@/Pages/Account/Partials/SetPasswordForm.vue'

defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
})
</script>

<template>
  <AppLayout title="Profile">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight">
        Profile
      </h2>
    </template>

    <div>
      <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
        <div v-if="$page.props.jetstream.canUpdateProfileInformation">
          <UpdateProfileInformationForm :user="$page.props.auth.user" />

          <SectionBorder />
        </div>

        <div v-if="$page.props.jetstream.canUpdatePassword && $page.props.socialstream.hasPassword">
          <UpdatePasswordForm class="mt-10 sm:mt-0" />

          <SectionBorder />
        </div>

        <div v-else>
          <SetPasswordForm class="mt-10 sm:mt-0" />

          <SectionBorder />
        </div>

        <div
          v-if="$page.props.jetstream.canManageTwoFactorAuthentication && $page.props.socialstream.hasPassword">
          <TwoFactorAuthenticationForm
            :requires-confirmation="confirmsTwoFactorAuthentication"
            class="mt-10 sm:mt-0" />

          <SectionBorder />
        </div>

        <div v-if="$page.props.socialstream.show">
          <ConnectedAccountsForm class="mt-10 sm:mt-0" />
        </div>

        <div v-if="$page.props.socialstream.hasPassword">
          <SectionBorder />

          <LogoutOtherBrowserSessionsForm :sessions="sessions" class="mt-10 sm:mt-0" />
        </div>

        <template
          v-if="$page.props.jetstream.hasAccountDeletionFeatures && $page.props.socialstream.hasPassword">
          <SectionBorder />

          <DeleteUserForm class="mt-10 sm:mt-0" />
        </template>
      </div>
    </div>
  </AppLayout>
</template>
