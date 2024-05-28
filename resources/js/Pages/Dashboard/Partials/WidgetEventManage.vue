<script setup>
import { Link} from '@inertiajs/vue3'
defineProps({
})

const title = 'イベント管理'
const iconType = 'event'
const manageUrl = route('event.manage')
const createUrl = route('event.create')
</script>
<template>
  <div class="card bg-base-200 text-center shadow-md">
    <div class="card-body">
      <div class="card-title">
        <IconTypeMapper :type="iconType" />
        {{ title }}
      </div>
      <p class="text-sm">
      </p>
      <div class="card-actions justify-end">
        <Link class="btn btn-neutral btn-sm" :href="manageUrl">
          Manage
        </Link>
        <Link class="btn btn-neutral btn-sm" :href="createUrl">
          Create
        </Link>
      </div>
    </div>
  </div>
</template>
