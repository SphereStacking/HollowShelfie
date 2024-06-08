<script>
import { computed, defineComponent } from 'vue'

export default defineComponent({
  props: {
    hoursIncrement: { type: [Number, String], default: 1 },
    minutesIncrement: { type: [Number, String], default: 1 },
    is24: { type: Boolean, default: true },
    hoursGridIncrement: { type: [String, Number], default: 1 },
    minutesGridIncrement: { type: [String, Number], default: 5 },
    range: { type: Boolean, default: false },
    filters: { type: Object, default: () => ({}) },
    minTime: { type: Object, default: () => ({}) },
    maxTime: { type: Object, default: () => ({}) },
    timePicker: { type: Boolean, default: false },
    hours: { type: [Number, Array], default: 0 },
    minutes: { type: [Number, Array], default: 0 },
    customProps: { type: Object, default: null }
  },
  emits: ['update:hours', 'update:minutes'],
  setup(props) {
    // Generate array of hours
    const hoursArray = computed(() => {
      const arr = []
      for (let i = 0; i < 24; i=i+props.hoursGridIncrement) {
        arr.push({ text: i < 10 ? `0${i}` : i, value: i })
      }
      return arr
    })

    // Generate array of minutes
    const minutesArray = computed(() => {
      const arr = []
      for (let i = 0; i < 60; i=i+props.minutesGridIncrement) {
        arr.push({ text: i < 10 ? `0${i}` : i, value: i })
      }
      return arr
    })

    return {
      hoursArray,
      minutesArray,
    }
  },
})
</script>

<template>
  <div class="flex items-center justify-center">
    <select
      class="select select-sm  py-0"
      :value="hours"
      @change="$emit('update:hours', +$event.target.value)">
      <option
        v-for="h in hoursArray"
        :key="h.value"
        :value="h.value">
        {{ h.text }}
      </option>
    </select>
    :
    <select
      class="select select-sm  py-0"
      :value="minutes"
      @change="$emit('update:minutes', +$event.target.value)">
      <option
        v-for="m in minutesArray"
        :key="m.value"
        :value="m.value">
        {{ m.text }}
      </option>
    </select>
  </div>
</template>

<style lang="">

</style>
