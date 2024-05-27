<script setup>
import { usePage } from '@inertiajs/vue3'

defineProps({
})

const title = '公開プロファイル'
const iconType = 'setting'
const routeUrl = usePage().props.auth.user.profile_url
</script>
<template>
  <div class="card bg-base-200  text-center shadow-md">
    <div class="card-body">
      <div class="card-title">
        <IconTypeMapper :type="iconType" />
        {{ title }}
      </div>
      <p class="text-sm">
      </p>
      <div class="card-actions justify-end">
        <a class="btn btn-neutral btn-sm" :href="routeUrl">
          Profile
        </a>
      </div>
    </div>
  </div>
</template>
