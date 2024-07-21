<script setup>
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

</script>

<template>
  <VueDatePicker dark inline>
    <slot></slot>
    <template v-for="(_, slotName) in $slots" #[slotName]="slotProps">
      <slot :name="slotName" v-bind="slotProps"></slot>
    </template>
  </VueDatePicker>
</template>

<style lang="">
</style>
