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
    :disabled="!editor.can().chain().focus().toggleBold().run()"
    :class="{
      'text-primary-60': editor.isActive('bold'),
      'btn-disabled': !editor.can().chain().focus().toggleBold().run(),
    }"
    @click="editor.chain().focus().toggleBold().run()">
    <IconTypeMapper type="formatBold" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
