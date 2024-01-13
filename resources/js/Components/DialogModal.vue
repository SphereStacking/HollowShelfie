<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  maxWidth: {
    type: String,
    default: '2xl',
  },
  closeable: {
    type: Boolean,
    default: true,
  },
})
const close = () => {
  this.$emit('close')
}

const emit = defineEmits(['close'])

</script>
<template>
  <modal
    :show="show" :max-width="maxWidth" :closeable="closeable"
    @close="close">
    <div class="px-6 py-4">
      <div class="text-lg">
        <slot name="title"></slot>
      </div>

      <div class="mt-4">
        <slot name="content"></slot>
      </div>
    </div>

    <div class="bg-gray-100 px-6 py-4 text-right">
      <slot name="footer"></slot>
    </div>
  </modal>
</template>

