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
    :disabled="!editor.can().chain().focus().toggleItalic().run()"
    :class="{
      'text-primary-60': editor.isActive('italic'),
      'btn-disabled': !editor.can().chain().focus().toggleItalic().run(),
    }"
    class="btn btn-xs"
    @click="!editor.chain().focus().toggleItalic().run()">
    <icon icon="mdi:format-italic" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
