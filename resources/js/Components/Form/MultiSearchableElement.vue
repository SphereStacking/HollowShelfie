<script setup>

const props = defineProps({
  //Wrapper用
  label: {
    type: String,
    default: ''
  },
  labelIconType: {
    type: String,
    default: ''
  },
  help: {
    type: String,
    default: ''
  },
  error: {
    type: String,
    default: ''
  },
})

</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :label-icon-type="labelIconType">
    <MultiSearchable v-bind="$attrs">
      <template #searchItem="{ item, handleAdd}">
        <slot :item="item" :handle-add="handleAdd" name="searchItem"></slot>
      </template>
      <template #notExist="{ inputText, handleAdd}">
        <slot :input-text="inputText" :handle-add="handleAdd" name="notExist"></slot>
      </template>
    </MultiSearchable>
  </Wrapper>
</template>

<style lang="">
</style>
