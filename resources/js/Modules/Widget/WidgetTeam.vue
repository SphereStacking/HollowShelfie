<script setup>
import { usePage, Link } from '@inertiajs/vue3'

defineProps({
})

const title = 'チームを作成する'
const iconType = 'teamCreate'
const routeUrl = route('teams.create')
</script>
<template>
  <div class="card bg-base-300  text-center shadow-md">
    <div class="card-body">
      <div class="card-title">
        <IconTypeMapper :type="iconType" />
        {{ title }}
      </div>
      <p class="text-sm">
      </p>
      <div class="card-actions justify-end">
        <Link class="btn btn-neutral btn-sm" :href="routeUrl">
          Create
        </Link>
      </div>
    </div>
  </div>
</template>
