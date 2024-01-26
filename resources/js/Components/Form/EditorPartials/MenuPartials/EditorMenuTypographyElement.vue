<script setup>

const props =defineProps({
  editor: {
    type: Object,
    default: ()=>{},
    required: true
  },
})

const typographyOptions = [
  {label: 'テキスト', value: 'p', icon: 'mdi:format-text', nodeName: 'paragraph', nodeAttrs: {} },
  {label: '見出し1', value: 'h1', icon: 'mdi:format-header-1', nodeName: 'heading', nodeAttrs: { level: 1 },},
  {label: '見出し2', value: 'h2', icon: 'mdi:format-header-2', nodeName: 'heading', nodeAttrs: { level: 2 },},
  {label: '見出し3', value: 'h3', icon: 'mdi:format-header-3', nodeName: 'heading', nodeAttrs: { level: 3 },},
  // {label: '見出し4', value: 'h4', icon: 'mdi:format-header-4', nodeName: 'heading', nodeAttrs: { level: 4 },},
  // {label: '見出し5', value: 'h5', icon: 'mdi:format-header-5', nodeName: 'heading', nodeAttrs: { level: 5 },},
  // {label: '見出し6', value: 'h6', icon: 'mdi:format-header-6', nodeName: 'heading', nodeAttrs: { level: 6 },},
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
      <Icon :icon="value.icon" class="text-lg" />
    </button>
  </div>
</template>

<style scoped>

</style>
