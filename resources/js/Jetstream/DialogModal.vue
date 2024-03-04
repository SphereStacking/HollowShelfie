<script setup>

const emit = defineEmits(['close'])

defineProps({
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
  emit('close')
}
</script>

<template>
  <Modal
    :show="show"
    :max-width="maxWidth"
    :closeable="closeable"
    @close="close">
    <div class="min-h-64 px-6 py-4 sm:px-8 sm:py-12">
      <div class="text-2xl font-medium text-base-content sm:text-3xl">
        <slot name="title"></slot>
      </div>

      <div class="mt-4 text-lg text-base-content sm:text-xl">
        <slot name="content"></slot>
      </div>
    </div>

    <div class="flex flex-row justify-end bg-base-300 px-6 py-4 text-end">
      <slot name="footer"></slot>
    </div>
  </Modal>
</template>
