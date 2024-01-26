<script setup>
import {Icon} from '@iconify/vue'

const props= defineProps({
  editor: {
    type: Object,
    default: ()=>{},
    required: true
  },
})
const setLink = () => {
  const previousUrl = props.editor.getAttributes('link').href
  const url = window.prompt('URL', previousUrl)

  if (url === null) {
    return
  }

  if (url === '') {
    props.editor.chain().focus().extendMarkRange('link').unsetLink().run()
    return
  }

  props.editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
}
</script>

<template>
  <button
    class="btn btn-xs"
    @click="setLink">
    <Icon icon="mdi:link-variant" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
