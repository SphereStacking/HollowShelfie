<script setup>
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

</script>

<template>
  <VueDatePicker dark>
    <slot></slot>
    <template v-for="(_, slotName) in $slots" #[slotName]="slotProps">
      <slot :name="slotName" v-bind="slotProps"></slot>
    </template>
    <template #dp-input="{ value,onInput }">
      <div class="relative">
        <input
          v-bind="$attrs"
          type="text" :value="value" class="input input-sm w-full"
          @input="onInput">
      </div>
    </template>
  </VueDatePicker>
</template>

<style lang="">
</style>
