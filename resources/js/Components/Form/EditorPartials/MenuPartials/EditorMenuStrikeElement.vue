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
    class="btn btn-sm"
    :class="{ 'is-active': editor.isActive('strike') }"
    @click="editor.chain().focus().toggleStrike().run()">
    <IconTypeMapper type="strikethrough" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
