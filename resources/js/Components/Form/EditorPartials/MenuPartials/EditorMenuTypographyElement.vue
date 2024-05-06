<script setup>

const props =defineProps({
  editor: {
    type: Object,
    default: ()=>{},
    required: true
  },
})

const typographyOptions = [
  {label: 'テキスト', value: 'p', icon: 'formatText', nodeName: 'paragraph', nodeAttrs: {} },
  {label: '見出し1', value: 'h1', icon: 'formatHeader1', nodeName: 'heading', nodeAttrs: { level: 1 },},
  {label: '見出し2', value: 'h2', icon: 'formatHeader2', nodeName: 'heading', nodeAttrs: { level: 2 },},
  {label: '見出し3', value: 'h3', icon: 'formatHeader3', nodeName: 'heading', nodeAttrs: { level: 3 },},
]

const changeTypography = (typography) => {
  if (typography?.nodeName !== 'heading') {
    props.editor.chain().focus().clearNodes().run()
    return
  }
  props.editor.chain().focus().toggleHeading({ level: 3 }).run()
}

</script>

<template>
  <div class="join">
    <button
      v-for=" (value,index) in typographyOptions" :key="index" class="btn join-item btn-xs"
      @click="changeTypography(value)">
      <IconTypeMapper :type="value.icon" class="text-lg" />
    </button>
  </div>
</template>

<style scoped>

</style>
