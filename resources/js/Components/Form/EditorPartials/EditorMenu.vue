<script setup>

const props=defineProps({
  editor: {
    type: Object,
    default: ()=>{}
  },
})

const isShowTableOpe = computed(() => {
  return props.editor.isActive('table')
})

const isShowAlign = computed(() => {
  return props.editor.isActive('link') || props.editor.isActive('paragraph') || props.editor.isActive('heading')
})
</script>

<template>
  <div
    v-if="editor"
    class=" w-full px-1 pt-1">
    <div class="flex flex-col gap-1 ">
      <div class="flex w-full  flex-wrap items-center gap-1">
        <div class="join">
          <editor-menu-undo-element :editor="editor" class="join-item" />
          <editor-menu-redo-element :editor="editor" class="join-item" />
        </div>
        <editor-menu-typography-element :editor="editor" />
        <div class="join">
          <editor-menu-underline-element :editor="editor" class="join-item" />
          <editor-menu-bold-element :editor="editor" class="join-item" />
          <editor-menu-italic-element :editor="editor" class="join-item" />
        </div>
        <div class="join">
          <editor-menu-bulletlist-element :editor="editor" class="join-item" />
          <editor-menu-orderedlist-element :editor="editor" class="join-item" />
          <!-- <EditorMenuTasklistElement :editor="editor" class="join-item" /> -->
        </div>
        <div class="join">
          <editor-menu-table-element :editor="editor" class="join-item" />
          <EditorMenuVideoElement :editor="editor" class="join-item" />
          <!-- <editor-menu-image-element :editor="editor" class="join-item" /> -->
          <editor-menu-link-element :editor="editor" class="join-item" />
        </div>
        <div class="join">
          <EditorMenuBlockquoteElement :editor="editor" class="join-item" />
        </div>
        <!-- TODO: 一旦機能初期リリースの機能から外す。 -->
        <!-- <div class="join">
          <EditorMenuAtElement :editor="editor" class="join-item" />
          <EditorMenuHashElement :editor="editor" class="join-item" />
        </div> -->

        <editor-menu-divider-element :editor="editor" />
        <!-- 選択nodeによってメニュを変える。 -->
        <editor-menu-color-element v-if="isShowAlign" :editor="editor" />
        <editor-menu-align-element v-if="isShowAlign" :editor="editor" />
        <EditorMenuTableOperationElement v-if="isShowTableOpe" :editor="editor" />
      </div>
    </div>
    <div class="divider m-0 p-0"></div>
  </div>
</template>

<style scoped>

</style>
