<script setup>
import { useTextareaAutosize } from '@vueuse/core'

const manualTextarea = ref(null)
const { textarea: autosizeTextarea, input: autosizeInput } = useTextareaAutosize()

const props = defineProps({
  id: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    required: true
  },
  modelValue: {
    type: String,
    default: 'hoge'
  },
  placeholder: {
    type: String,
    default: ''
  },
  help: {
    type: String,
    default: null
  },
  error: {
    type: String,
    default: null
  },
  type: {
    type: String,
    default: 'text'
  },
  autoResize: {
    type: Boolean,
    default: false
  }
})

defineEmits(['update:modelValue'])
const textareaRef = computed(() => props.autoResize ? autosizeTextarea : manualTextarea)

watch(() => props.modelValue, (newVal) => {
  if (props.autoResize) {
    autosizeInput.value = newVal
  }
})
</script>

<template>
  <Wrapper :label="label" :help="help" :error="error">
    <textarea
      :id="id"
      :ref="textareaRef"
      class="textarea textarea-bordered w-full rounded-md"
      :class="{ 'auto-resize-textarea': autoResize }"
      :placeholder="placeholder"
      :value="modelValue"
      aria-describedby="input-help"
      @input="$emit('update:modelValue', $event.target.value)"></textarea>
  </Wrapper>
</template>

<style scoped>
.auto-resize-textarea {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.auto-resize-textarea::-webkit-scrollbar {
  display: none;
}
</style>
