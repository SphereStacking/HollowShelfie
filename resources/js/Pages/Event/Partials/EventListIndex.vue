
<script setup>
defineProps({
  title: {
    type: String,
    required: true
  },
  events: {
    type: Array,
    required: true
  },
})
</script>

<template>
  <div>
    <div class="flex flex-row justify-between">
      <h3 class="font-semibold leading-tight text-neutral align-bottom text-4xl">
        {{ title }}
      </h3>
      <slot name="header">
      </slot>
    </div>
    <div class=" w-full grid grid-cols-4 gap-6 my-2">
      <CardEvent v-for="(item, index) in events" :key="index" :event="item" />
    </div>
    <div class="flex flex-row justify-center">
      <slot name="footer">

      </slot>
    </div>
  </div>
</template>
