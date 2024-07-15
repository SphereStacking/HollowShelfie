
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
  createCalendarEvent('icalendar', {
    title: props.title,
    dates: props.dates,
    description: props.description,
    location: props.location,
    links: props.links
  })
}

</script>
<template>
  <button @click="create()">
    <IconTypeMapper type="iCalendar" class="text-lg" />
    iCalendar
  </button>
</template>
<style lang="">

</style>
