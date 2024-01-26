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
    <Icon icon="mdi:format-strikethrough-variant" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
