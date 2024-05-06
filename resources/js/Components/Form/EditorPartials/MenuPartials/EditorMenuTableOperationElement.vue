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
  <div class="flex flex-wrap gap-1">
    <div class="join">
      <button class="btn join-item btn-xs" @click="editor.chain().focus().addColumnBefore().run()">
        <IconTypeMapper type="tableColumnPlusBefore" class="text-lg" />
      </button>
      <button class="btn join-item btn-xs" @click="editor.chain().focus().addColumnAfter().run()">
        <IconTypeMapper type="tableColumnPlusAfter" class="text-lg" />
      </button>
      <button class="btn join-item btn-xs" @click="editor.chain().focus().deleteColumn().run()">
        <IconTypeMapper type="tableColumnRemove" class="text-lg" />
      </button>
    </div>
    <div class="join">
      <button class="btn join-item btn-xs" @click="editor.chain().focus().addRowBefore().run()">
        <IconTypeMapper type="tableRowPlusBefore" class="text-lg" />
      </button>
      <button class="btn join-item btn-xs" @click="editor.chain().focus().addRowAfter().run()">
        <IconTypeMapper type="tableRowPlusAfter" class="text-lg" />
      </button>
      <button class="btn join-item btn-xs" @click="editor.chain().focus().deleteRow().run()">
        <IconTypeMapper type="tableRowRemove" class="text-lg" />
      </button>
    </div>
    <div class="join">
      <button class="btn join-item btn-xs" @click="editor.chain().focus().deleteTable().run()">
        <IconTypeMapper type="tableRemove" class="text-lg" />
      </button>
    </div>
    <div class="join">
      <button class="btn join-item btn-xs" @click="editor.chain().focus().mergeCells().run()">
        <IconTypeMapper type="tableMergeCells" class="text-lg" />
      </button>
      <button class="btn join-item btn-xs" @click="editor.chain().focus().splitCell().run()">
        <IconTypeMapper type="tableSplitCell" class="text-lg" />
      </button>
    </div>
    <div class="join">
      <button class="btn join-item btn-xs" @click="editor.chain().focus().toggleHeaderCell().run()">
        <IconTypeMapper type="toggleHeaderCell" class="text-lg" />
      </button>
    </div>
  </div>
</template>

<style scoped>

</style>
