<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'

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

const emit = defineEmits(['close'])
const dialog = ref()
const showSlot = ref(props.show)

watch(() => props.show, () => {
  if (props.show) {
    document.body.style.overflow = 'hidden'
    showSlot.value = true
    dialog.value?.showModal()
  } else {
    document.body.style.overflow = null
    setTimeout(() => {
      dialog.value?.close()
      showSlot.value = false
    }, 200)
  }
})

const close = (e) => {
  if (props.closeable) {
    emit('close')
    e.preventDefault()
  }
}

const closeOnEscape = (e) => {
  if (e.key === 'Escape' && props.show) {
    close()
  }
}

onMounted(() => document.addEventListener('keydown', closeOnEscape))

onUnmounted(() => {
  document.removeEventListener('keydown', closeOnEscape)
  document.body.style.overflow = null
})

const maxWidthClass = computed(() => {
  return {
    'sm': 'sm:max-w-sm',
    'md': 'sm:max-w-md',
    'lg': 'sm:max-w-lg',
    'xl': 'sm:max-w-xl',
    '2xl': 'sm:max-w-2xl',
  }[props.maxWidth]
})
</script>

<template>
  <dialog ref="dialog" class="z-50 m-0 min-h-full min-w-full overflow-y-auto bg-transparent backdrop:bg-transparent">
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto px-4 py-6 sm:px-0" scroll-region>
      <transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0">
        <div v-show="show" class="fixed inset-0 translate-x-0 transition-all" @click="close">
          <div class="absolute inset-0 bg-base-100 opacity-75"></div>
        </div>
      </transition>
      <transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div v-show="show" class="mb-6 translate-x-0 overflow-hidden rounded-lg bg-base-200 shadow-xl transition-all sm:mx-auto sm:w-full" :class="maxWidthClass">
          <slot v-if="showSlot"></slot>
        </div>
      </transition>
    </div>
  </dialog>
</template>
