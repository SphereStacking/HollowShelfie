<script setup>

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
      'is-active': !editor.can().chain().focus().redo().run(),
    }"
    :disabled="!editor.can().chain().focus().redo().run()"
    @click="editor.chain().focus().redo().run()">
    <IconTypeMapper type="redo" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
