<script setup>

const props = defineProps({
  editor: {
    type: Object,
    default: ()=>{},
    required: true
  },
})

const width= ref(360)
const height = ref(280)
const addVideo= () => {
  const url = prompt('Enter YouTube URL')

  props.editor.commands.setYoutubeVideo({
    src: url,
    width: width.value,
    height: height.value
  })
  props.editor.chain().focus().setHardBreak().run()
}
</script>

<template>
  <button
    class="btn btn-xs"
    @click="addVideo">
    <IconTypeMapper type="youtube" class="text-lg" />
  </button>
</template>

<style scoped>

</style>
