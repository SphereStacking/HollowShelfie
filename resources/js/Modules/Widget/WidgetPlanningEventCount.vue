<script setup>
import { usePage } from '@inertiajs/vue3'
const page = usePage()

defineProps({
})

const link = {
  title: '開催予定',
  routeUrl: page.props.upcomingEventsUrl,
  icon: 'eventUpcoming',
  discription: usePage().props.upcomingEventCount || 0,
}
</script>
<template>
  <WidgetCardBase :link="link" content-class="justify-between flex flex-row h-full">
    <template #discription>
      <div class="flex items-end text-end font-mono text-6xl">
        {{ link.discription }}
      </div>
    </template>
  </WidgetCardBase>
</template>
