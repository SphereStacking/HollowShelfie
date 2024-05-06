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
    :class="{ 'is-active': editor.isActive('bulletList') }"
    @click="editor.chain().focus().toggleOrderedList().run()">
    <IconTypeMapper type="formatListNumbered" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
