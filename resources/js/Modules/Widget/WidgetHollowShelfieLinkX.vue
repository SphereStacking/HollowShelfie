<script setup>
import { usePage } from '@inertiajs/vue3'
const page = usePage()

defineProps({
})
const link = {
  title: 'X',
  routeUrl: page.props.config.twitter,
  icon: 'twitter',
  target: '_blank',
  rel: 'noopener noreferrer',
  discription: '更新情報や掲載情報をポストしていく予定です！',
}
</script>
<template>
  <WidgetCardBase :link="link" />
</template>
