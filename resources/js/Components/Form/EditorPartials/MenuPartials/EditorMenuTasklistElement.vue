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
    :class="{ 'is-active': editor.isActive('taskList') }"
    @click="editor.chain().focus().toggleTaskList().run()">
    <IconTypeMapper type="formatListChecks" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
