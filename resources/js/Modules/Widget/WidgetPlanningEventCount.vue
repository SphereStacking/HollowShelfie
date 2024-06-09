<script setup>
import { Link, usePage } from '@inertiajs/vue3'

defineProps({
})

const title = '開催予定'
const iconType = 'eventPlanning'
const routeUrl = usePage().props.upcomingEventsUrl
const count = usePage().props.upcomingEventCount || 0
</script>
<template>
  <div class="card bg-base-300 text-center shadow-md">
    <div class="card-body">
      <div class="card-title">
        <IconTypeMapper :type="iconType" />
        {{ title }}
      </div>
      <div class="flex items-end justify-around font-mono text-5xl">
        <p>{{ count }}</p>
        <Link class="btn btn-neutral btn-sm" :href="routeUrl">
          <span class="flex items-center">
            View all
            <IconTypeMapper type="arrowRight" class="text-xl" />
          </span>
        </Link>
      </div>
    </div>
  </div>
</template>
