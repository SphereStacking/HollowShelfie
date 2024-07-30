<script setup>
import { usePage } from '@inertiajs/vue3'
const page = usePage()

defineProps({
})
const link = {
  title: 'Discord',
  routeUrl: page.props.config.discordInvite,
  icon: 'discord',
  target: '_blank',
  rel: 'noopener noreferrer',
  discription: 'サポートや要望など、Discordからご連絡おねがいします！',
}

</script>
<template>
  <WidgetCardBase :link="link" />
</template>
