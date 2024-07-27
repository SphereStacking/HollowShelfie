<script setup>

defineProps({
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
  warning: {
    type: String,
    default: null
  },
})

</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :warning="warning" :label-icon-type="labelIconType">
    <MultiSearchable v-bind="$attrs">
      <template #viewItem="{ element, handleDelete }">
        <slot :element="element" :handle-delete="handleDelete" name="viewItem"></slot>
      </template>
      <template #searchItem="{ item, handleAdd, isSearching }">
        <slot
          :item="item" :handle-add="handleAdd" :is-searching="isSearching"
          name="searchItem"></slot>
      </template>
      <template #notExist="{ inputText, handleAdd }">
        <slot :input-text="inputText" :handle-add="handleAdd" name="notExist"></slot>
      </template>
    </MultiSearchable>
  </Wrapper>
</template>

<style lang="">
</style>
