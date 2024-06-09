<script setup>
import { usePage, Link } from '@inertiajs/vue3'

defineProps({
})

const title = 'Followers'
const iconType = 'follower'
const routeUrl = route('user.follower', usePage().props.auth.user.screen_name)
const count = usePage().props.counts.follower || 0
</script>
<template>
  <div class="card bg-base-300  text-center shadow-md">
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
