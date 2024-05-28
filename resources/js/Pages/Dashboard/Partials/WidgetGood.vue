<script setup>
import { usePage, Link } from '@inertiajs/vue3'

defineProps({
})

const title = 'Goods'
const iconType = 'onGood'
const routeUrl = route('user.good', usePage().props.auth.user.screen_name)
const count = usePage().props.counts.good?.total || 0
</script>
<template>
  <div class="card bg-base-200 text-center shadow-md">
    <div class="card-body">
      <div class="card-title">
        <IconTypeMapper :type="iconType" />
        {{ title }}
      </div>
      <p class="text-sm">
        {{ count }}
      </p>
      <div class="card-actions justify-end">
        <Link class="btn btn-neutral btn-sm" :href="routeUrl">
          View all
        </Link>
      </div>
    </div>
  </div>
</template>
