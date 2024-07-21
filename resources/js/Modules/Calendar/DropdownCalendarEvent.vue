<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  width: {
    type: String,
    default: 'w-52',
  },
  title: {
    type: String,
    default: () => 'HollowShelfie'
  },
  dates: {
    type: Array,
    default: () => []
  },
  description: {
    type: String,
    default: () => ''
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
</script>

<template>
  <BtnDropdown>
    <template #trigger>
      <button class="btn btn-xs">
        <IconTypeMapper type="calendarAdd" class="text-xl" />
      </button>
    </template>
    <BtnDropdownItem>
      <CalendarEventCreateGoogle
        :title="title" :dates="dates" :description="description"
        :links="links"
        :location="location" />
    </BtnDropdownItem>
    <BtnDropdownItem>
      <CalendarEventCreateIcalendar
        :title="title" :dates="dates" :description="description"
        :links="links"
        :location="location" />
    </BtnDropdownItem>
  </BtnDropdown>
</template>

<style scoped>
</style>
