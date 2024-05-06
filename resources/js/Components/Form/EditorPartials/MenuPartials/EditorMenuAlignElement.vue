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
  <div class="join join-horizontal">
    <button
      class="btn join-item btn-xs"
      :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }" @click="editor.chain().focus().setTextAlign('left').run()">
      <IconTypeMapper type="formatAlignLeft" class="text-lg" />
    </button>
    <button class="btn join-item btn-xs" :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }" @click="editor.chain().focus().setTextAlign('center').run()">
      <IconTypeMapper type="formatAlignCenter" class="text-lg" />
    </button>
    <button
      class="btn join-item btn-xs" :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }" @click="editor.chain().focus().setTextAlign('right').run()">
      <IconTypeMapper type="formatAlignRight" class="text-lg" />
    </button>
    <!--    <button class="btn join-item btn-xs" :class="{ 'is-active': editor.isActive({ textAlign: 'justify' }) }" @click="editor.chain().focus().setTextAlign('justify').run()">-->
    <!--      <IconTypeMapper type="formatAlignJustify" class="text-lg" />-->
    <!--    </button>-->
    <!--    <button class="btn join-item btn-xs" @click="editor.chain().focus().unsetTextAlign().run()">-->
    <!--      unsetTextAlign-->
    <!--    </button>-->
  </div>
</template>

<style scoped>

</style>
