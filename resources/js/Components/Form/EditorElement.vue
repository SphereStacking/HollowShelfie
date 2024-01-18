<script setup>
import { ref } from 'vue'

import Editor from '@tinymce/tinymce-vue'

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
    default: ''
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
  }
})

const tinymceOptions = {
  skin: 'oxide-dark',
  content_css: 'dark',
  statusbar: false,
  menubar: true,
  language: 'ja',
  plugins: 'autolink charmap  emoticons image link lists media searchreplace table visualblocks wordcount ',
  toolbar: 'blocks bold italic underline strikethrough forecolor removeformat | emoticons link image table | numlist bullist ',

}

const emit = defineEmits(['update:modelValue'])

const data = ref(props.modelValue)

watch(data, (newValue) => {
  emit('update:modelValue', newValue)
})
</script>
<template>
  <Wrapper :label="label" :help="help" :error="error">
    <div class="w-full ">
      <editor
        v-model="data"
        :init="tinymceOptions"
        api-key="4qnmsotx5i7dhoxoauuflkoztyubh347mirovtjgd6pp2fj3" />
    </div>
  </Wrapper>
</template>
<style>

</style>
