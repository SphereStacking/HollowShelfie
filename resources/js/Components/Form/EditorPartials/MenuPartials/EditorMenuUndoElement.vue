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
      'btn-disabled': !editor.can().chain().focus().undo().run(),
    }"
    :disabled="!editor.can().chain().focus().undo().run()"
    @click="editor.chain().focus().undo().run()">
    <Icon icon="mdi:undo" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
