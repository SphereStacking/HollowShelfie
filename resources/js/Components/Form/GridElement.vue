<script setup>
defineProps({
  label: {
    type: String,
    required: true
  },
  labelIconType: {
    type: String,
    default: ''
  },
  help: {
    type: String,
    default: null
  },
  error: {
    type: String,
    default: null
  },

})

</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :label-icon-type="labelIconType">
    <Grid v-bind="$attrs" />
  </Wrapper>
</template>

<style lang="">
</style>
