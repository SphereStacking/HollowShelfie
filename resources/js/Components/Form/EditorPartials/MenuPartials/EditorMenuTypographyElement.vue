<script setup>
const props = defineProps({
  editor: {
    type: Object,
    default: () => ({}),
    required: true
  },
})

const headingTypography = (level) => {
  props.editor.chain().focus().toggleHeading({ level: level }).run()
}

const clearTypography = () => {
  props.editor.chain().focus().clearNodes().run()
}

const typographyOptions = [
  {label: 'テキスト', value: 'p', icon: 'formatText', action: clearTypography},
  {label: '見出し1', value: 'h1', icon: 'formatHeader1', action: () => headingTypography(1)},
  {label: '見出し2', value: 'h2', icon: 'formatHeader2', action: () => headingTypography(2)},
  {label: '見出し3', value: 'h3', icon: 'formatHeader3', action: () => headingTypography(3)},
]
const typographySelectOptions = [
  {label: '見出し4', value: 'h4', icon: 'formatHeader4', action: () => headingTypography(4)},
  {label: '見出し5', value: 'h5', icon: 'formatHeader5', action: () => headingTypography(5)},
  {label: '見出し6', value: 'h6', icon: 'formatHeader6', action: () => headingTypography(6)},
]
const handleSelectChange = (event) => {
  const selectedValue = event.target.value
  const selectedOption = typographySelectOptions.find(option => option.value === selectedValue)
  if (selectedOption && selectedOption.action) {
    selectedOption.action()
  }
}

</script>

<template>
  <div class="join">
    <button
      v-for="(value, index) in typographyOptions"
      :key="index"
      class="btn join-item btn-xs"
      @click="value.action">
      <IconTypeMapper :type="value.icon" class="text-lg" />
    </button>
    <select class="join-item select select-xs bg-base-200 py-0" @change="handleSelectChange">
      <option v-for="(option, index) in typographySelectOptions" :key="index" :value="option.value">
        {{ option.label }}
      </option>
    </select>
  </div>
</template>

<style scoped>
</style>
