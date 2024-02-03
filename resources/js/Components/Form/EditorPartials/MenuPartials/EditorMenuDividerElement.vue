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
    @click="editor.chain().focus().setHorizontalRule().run()">
    <Icon icon="mdi:divide" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
