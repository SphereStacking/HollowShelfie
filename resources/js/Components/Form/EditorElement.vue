<script setup>
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
// import Strike from '@tiptap/extension-strike'
// import ListItem from '@tiptap/extension-list-item'
// import BulletList from '@tiptap/extension-bullet-list'
// import OrderedList from '@tiptap/extension-ordered-list'
// import Text from '@tiptap/extension-text'
// import Mention from '@tiptap/extension-mention'
// import Dropcursor from '@tiptap/extension-dropcursor'
import Link from '@tiptap/extension-link'
import Underline from '@tiptap/extension-underline'
import TextStyle from '@tiptap/extension-text-style'
import TextAlign from '@tiptap/extension-text-align'
import Focus from '@tiptap/extension-focus'
import Image from '@tiptap/extension-image'
import Youtube from '@tiptap/extension-youtube'
import TaskItem from '@tiptap/extension-task-item'
import TaskList from '@tiptap/extension-task-list'
import Table from '@tiptap/extension-table'
import TableCell from '@tiptap/extension-table-cell'
import TableHeader from '@tiptap/extension-table-header'
import TableRow from '@tiptap/extension-table-row'
import { Color } from '@tiptap/extension-color'

// import suggestionMention from './EditorPartials/SuggestionPartials/suggestionMention.js'
// import suggestionTag from './EditorPartials/SuggestionPartials/suggestionTag.js'

const props = defineProps({
  id: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    required: true
  },
  labelIconType: {
    type: String,
    default: ''
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
  warning: {
    type: String,
    default: null
  },
  type: {
    type: String,
    default: 'text'
  }
})

const emit =defineEmits(['update:modelValue'])

const editor = new Editor({
  content: props.modelValue,
  injectCSS: false,
  extensions: [
    StarterKit,
    Image,
    Link.configure({
      openOnClick: false,
    }),
    Table.configure({
      resizable: true,
    }),
    Youtube.configure({
      inline: true,
      HTMLAttributes: {
        class: 'w-full aspect-video md:aspect-square',
      },
    }),
    TableRow,
    TableHeader,
    TableCell,
    Underline,
    TextAlign.configure({
      types: ['heading', 'paragraph'],
    }),
    TextStyle,
    Color,
    Focus.configure({
      className: 'bg-base-300/25',
      mode: 'all',
    }),
    // TODO: 一旦機能初期リリースの機能から外す。
    // Mention.configure({
    //   HTMLAttributes: {
    //     class: 'rounded-md bg-base-300 my-1 p-2 text-sm',
    //   },
    //   suggestion: suggestionMention,
    // }),
    // Mention.configure({
    //   HTMLAttributes: {
    //     class: 'rounded-md bg-base-300 my-1 p-2 text-sm',
    //   },
    //   suggestion: suggestionTag,
    // }),
    TaskList,
    TaskItem.configure({
      nested: true,
    }),
  ],
  editorProps: {
    attributes: {
      class: 'prose prose-sm sm:prose lg:prose-lg xl:prose-2xl focus:outline-none min-h-48'
    },
  },
})

const innerValue = computed(() => {
  return editor.isEmpty ? '' : editor.getHTML()
})

watch(innerValue, (v) => {
  emit('update:modelValue', v)
})

onBeforeUnmount(() => {
  editor.destroy()
})

const setContent = (value) => {
  editor.commands.setContent(value)
}

defineExpose({
  setContent,
})

</script>
<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :warning="warning" :label-icon-type="labelIconType">
    <div class="w-full rounded-md bg-base-100  ">
      <EditorMenu :editor="editor" class="sticky top-16 z-20 rounded-md bg-base-100" />
      <EditorContent :editor="editor" class="mx-2 mb-2" />
    </div>
  </Wrapper>
</template>
<style scoped>
</style>
