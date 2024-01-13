<script setup>
import VueTailwindDatepicker from 'vue-tailwind-datepicker'

const dateValue = ref([])
const formatter = ref({
  date: 'YYYY-MM-DD',
  month: 'MM',
})
</script>

<template>
  <vue-tailwind-datepicker
    v-model="dateValue" i18n="ja" :formatter="formatter"
    dark />
</template>
