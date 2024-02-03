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
    @click="editor.chain().focus().toggleBulletList().run()">
    <Icon icon="mdi:format-list-bulleted" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
