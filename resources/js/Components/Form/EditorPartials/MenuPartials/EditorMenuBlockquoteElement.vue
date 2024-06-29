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
    @click="editor.chain().focus().toggleBlockquote().run()">
    <IconTypeMapper type="quote" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
