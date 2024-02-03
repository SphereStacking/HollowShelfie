<script setup>
import {Icon} from '@iconify/vue'

const props= defineProps({
  editor: {
    type: Object,
    default: ()=>{},
    required: true
  },
})

const addImage = () => {
  const url = window.prompt('URL')

  if (url) {
    props.editor.chain().focus().setImage({ src: url }).run()
  }
}

</script>

<template>
  <button
    class="btn btn-xs"
    @click="addImage">
    <Icon icon="mdi:image" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
