<script setup>
import { Link, usePage } from '@inertiajs/vue3'

defineProps({
})

const title = 'イベント管理'
const iconType = 'event'
const manageUrl = route('event.manage')
const createUrl = route('event.create')

const page = usePage()
const eventDraft = page.props.counts.eventDraft
const eventPublished = page.props.counts.eventPublished
</script>
<template>
  <div class="card bg-base-300 text-center shadow-md">
    <div class="card-body">
      <div class="card-title">
        <IconTypeMapper :type="iconType" />
        {{ title }}
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="flex items-end justify-around">
          <div class="flex w-full flex-row justify-around gap-2">
            <span class="flex flex-col gap-2 md:flex-row md:gap-4">
              Draft:<p class="font-mono text-5xl">
                {{ eventDraft }}
              </p>
            </span>
            <span class="flex flex-col gap-2 md:flex-row md:gap-4">
              Published:<p class="font-mono text-5xl">
                {{ eventPublished }}
              </p>
            </span>
          </div>
        </div>
        <div class="flex flex-col items-end justify-around md:flex-row">
          <Link class="btn btn-neutral btn-sm" :href="manageUrl">
            <span class="flex items-center">
              Manage
              <IconTypeMapper type="arrowRight" class="text-xl" />
            </span>
          </Link>
          <Link class="btn btn-neutral btn-sm" :href="createUrl">
            <span class="flex items-center">
              新規作成
              <IconTypeMapper type="arrowRight" class="text-xl" />
            </span>
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>
