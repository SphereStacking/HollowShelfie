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
  <div class="join join-horizontal">
    <button
      class="btn join-item btn-xs"
      :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }" @click="editor.chain().focus().setTextAlign('left').run()">
      <icon icon="mdi:format-align-left" class="text-lg" />
    </button>
    <button class="btn join-item btn-xs" :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }" @click="editor.chain().focus().setTextAlign('center').run()">
      <icon icon="mdi:format-align-center" class="text-lg" />
    </button>
    <button
      class="btn join-item btn-xs" :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }" @click="editor.chain().focus().setTextAlign('right').run()">
      <icon icon="mdi:format-align-right" class="text-lg" />
    </button>
    <!--    <button class="btn join-item btn-xs" :class="{ 'is-active': editor.isActive({ textAlign: 'justify' }) }" @click="editor.chain().focus().setTextAlign('justify').run()">-->
    <!--      <icon icon="mdi:format-align-justify" class="text-lg" />-->
    <!--    </button>-->
    <!--    <button class="btn join-item btn-xs" @click="editor.chain().focus().unsetTextAlign().run()">-->
    <!--      unsetTextAlign-->
    <!--    </button>-->
  </div>
</template>

<style scoped>

</style>
