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
    :class="{ 'is-active': editor.isActive('underline') }"
    @click="editor.chain().focus().toggleUnderline().run()">
    <Icon icon="mdi:format-underline" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
