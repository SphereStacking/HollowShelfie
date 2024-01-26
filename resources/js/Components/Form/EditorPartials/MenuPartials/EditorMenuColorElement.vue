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
  <input
    type="color"
    class="input input-xs w-10  border-0 bg-base-300 hover:bg-base-200 focus:outline-none "
    :value="editor.getAttributes('textStyle').color"
    @input="editor.chain().focus().setColor($event.target.value).run()">
</template>

<style scoped>

</style>
