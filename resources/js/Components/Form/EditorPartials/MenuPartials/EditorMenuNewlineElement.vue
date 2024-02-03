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
    class="btn btn-xs" @click="editor.chain().focus().setHardBreak().run()">
    <Icon icon="mdi:arrow-left-bottom-bold" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
