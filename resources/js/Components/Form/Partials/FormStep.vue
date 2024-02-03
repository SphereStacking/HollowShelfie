<script setup>
defineProps({
  name: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    required: true
  },
  elements: {
    type: Array,
    default: () => []
  },

})

</script>

<template>
  <FormStep
    name="page1"
    label="Step 2"
    :elements="[
      'password',
      'phone',
    ]" />
</template>

<style lang="">
</style>
