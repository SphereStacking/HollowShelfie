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
      'is-active': !editor.can().chain().focus().undo().run(),
    }"
    :disabled="!editor.can().chain().focus().undo().run()"
    @click="editor.commands.insertTable({ rows: 3, cols: 3, withHeaderRow: true })">
    <IconTypeMapper type="tableLarge" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
