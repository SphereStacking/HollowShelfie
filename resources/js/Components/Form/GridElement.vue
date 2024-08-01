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
  errors: {
    type: String,
    default: null
  },
  //TODO:必要になったら処理を追加する。
  warnings: {
    type: String,
    default: null
  },
  modelValue: {
    type: Array,
    default: () => []
  }
})

</script>

<template>
  <Wrapper
    :label="label" :help="help"
    :label-icon-type="labelIconType">
    <Grid v-bind="$attrs" :errors="errors" :model-value="modelValue">
      <template #add-row-button="{ createNewRow }">
        <slot name="add-row-button" :create-new-row="createNewRow"></slot>
      </template>
    </Grid>
  </Wrapper>
</template>

<style lang="">
</style>
