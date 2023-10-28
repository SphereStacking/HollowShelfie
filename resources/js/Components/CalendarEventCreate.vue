<script setup>
import { createCalendarEvent } from '@/Utill/CreateCalendarEvent'

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
  details: {
    type: String,
    default: () => [],
    required: false,
  },
  location: {
    type: String,
    required: true
  },
})

const create = (type) => {
  let createurl = createCalendarEvent(type, props.title, props.dates, props.details, props.location)
  // 新しいタブで開く
  window.open(createurl, '_blank');
}

</script>
<template>
  <div class="dropdown dropdown-right">
    <label tabindex="0">
      <slot></slot>
    </label>
    <ul tabindex="0" class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box ">
      <li>
        <a @click="create('google')">
          <Icon icon="bxl:google" class="text-xl" />
        </a>
      </li>
      <li>
        <a @click="create('outlook')">
          <Icon icon="ph:microsoft-outlook-logo" class="text-xl" />
        </a>
      </li>
    </ul>
  </div>
</template>
<style lang="">

</style>
