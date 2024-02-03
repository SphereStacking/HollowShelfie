<script setup>

import {Icon} from '@iconify/vue'

defineProps({
  editor: {
    type: Object,
    default: ()=>{},
    required: true
  },
})
</script>

<template>
  <button
    class="btn btn-xs"
    :class="{
      'is-active': !editor.can().chain().focus().undo().run(),
    }"
    :disabled="!editor.can().chain().focus().undo().run()"
    @click="editor.commands.insertTable({ rows: 3, cols: 3, withHeaderRow: true })">
    <Icon icon="mdi:table-large" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
