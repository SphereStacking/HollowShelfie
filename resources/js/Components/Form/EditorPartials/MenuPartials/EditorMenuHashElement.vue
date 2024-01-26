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
    @click="editor.chain().focus().insertContent('#').run()">
    <Icon icon="mdi:hashtag" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
