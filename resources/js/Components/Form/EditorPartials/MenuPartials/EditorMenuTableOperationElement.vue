<script setup>

import {Icon} from '@iconify/vue'

defineProps({
  editor: {
    type: Object,
    default: ()=>{},
    required: true
  },
})
</script>

<template>
  <div class="flex flex-wrap gap-1">
    <div class="join">
      <button class="btn join-item btn-xs" @click="editor.chain().focus().addColumnBefore().run()">
        <Icon icon="mdi:table-column-plus-before" class="text-lg" />
      </button>
      <button class="btn join-item btn-xs" @click="editor.chain().focus().addColumnAfter().run()">
        <Icon icon="mdi:table-column-plus-after" class="text-lg" />
      </button>
      <button class="btn join-item btn-xs" @click="editor.chain().focus().deleteColumn().run()">
        <Icon icon="mdi:table-column-remove" class="text-lg" />
      </button>
    </div>
    <div class="join">
      <button class="btn join-item btn-xs" @click="editor.chain().focus().addRowBefore().run()">
        <Icon icon="mdi:table-row-plus-before" class="text-lg" />
      </button>
      <button class="btn join-item btn-xs" @click="editor.chain().focus().addRowAfter().run()">
        <Icon icon="mdi:table-row-plus-after" class="text-lg" />
      </button>
      <button class="btn join-item btn-xs" @click="editor.chain().focus().deleteRow().run()">
        <Icon icon="mdi:table-row-remove" class="text-lg" />
      </button>
    </div>
    <div class="join">
      <button class="btn join-item btn-xs" @click="editor.chain().focus().deleteTable().run()">
        <Icon icon="mdi:table-remove" class="text-lg" />
      </button>
    </div>
    <div class="join">
      <button class="btn join-item btn-xs" @click="editor.chain().focus().mergeCells().run()">
        <Icon icon="mdi:table-merge-cells" class="text-lg" />
      </button>
      <button class="btn join-item btn-xs" @click="editor.chain().focus().splitCell().run()">
        <Icon icon="mdi:table-split-cell" class="text-lg" />
      </button>
    </div>
    <div class="join">
      <button class="btn join-item btn-xs" @click="editor.chain().focus().toggleHeaderCell().run()">
        <Icon icon="mdi:format-color-fill" class="text-lg" />
      </button>
    </div>
  </div>
</template>

<style scoped>

</style>
