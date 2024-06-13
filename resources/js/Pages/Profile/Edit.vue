<script setup>
import { Link } from '@inertiajs/vue3'
const props = defineProps({
  profile: {
    type: Object,
    required: true
  },
  events: {
    type: Array,
    required: true
  },
  url: {
    type: String,
    required: true
  },
})

</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold  leading-tight">
        Profile Edit
      </h2>
    </template>
    <div class="mx-auto my-6 flex max-w-7xl flex-col gap-4">
      <AuthUserEditFormCard :profile="profile" />
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
