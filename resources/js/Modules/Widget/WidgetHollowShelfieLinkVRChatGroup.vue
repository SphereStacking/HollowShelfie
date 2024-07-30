<script setup>
import { usePage } from '@inertiajs/vue3'
const page = usePage()

defineProps({
})
const link = {
  title: 'VRChat Group',
  routeUrl: page.props.config.VRChatGroup,
  icon: 'vrchat',
  target: '_blank',
  rel: 'noopener noreferrer',
  discription: 'VRChatグループ',
}
</script>
<template>
  <WidgetCardBase :link="link" />
</template>
