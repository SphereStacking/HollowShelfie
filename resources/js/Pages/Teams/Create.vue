<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import CreateTeamForm from '@/Pages/Teams/Partials/CreateTeamForm.vue'
</script>

<template>
  <AppLayout title="Create Team">
    <template #header>
      <h2 class="text-xl font-semibold  leading-tight">
        Create Team
      </h2>
    </template>

    <div>
      <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
        <CreateTeamForm />
      </div>
    </div>
  </AppLayout>
</template>
