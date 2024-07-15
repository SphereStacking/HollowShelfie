
<script setup>
import { createCalendarEvent } from '@/Utils/CreateCalendarEvent'

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  dates: {
    type: Array,
    required: true,
    default: () => []
  },
  description: {
    type: String,
    default: () => '',
    required: false,
  },
  location: {
    type: String,
    default: () => ''
  },
  links: {
    type: Array,
    default: () => []
  }
})

const create = () => {
  let createurl = createCalendarEvent('google', {
    title: props.title,
    dates: props.dates,
    description: props.description,
    location: props.location,
    links: props.links
  })
  console.log(createurl)
  // 新しいタブで開く
  window.open(createurl, '_blank')
}

</script>
<template>
  <button @click="create()">
    <IconTypeMapper type="googleCalendar" class="text-lg" />
    Googleカレンダー
  </button>
</template>
<style lang="">

</style>
