<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'

const props = defineProps({
  align: {
    type: String,
    default: 'right',
  },
  width: {
    type: String,
    default: '48',
  },
  contentClasses: {
    type: Array,
    default: () => ['py-1', 'bg-base-100'],
  },
})

let open = ref(false)

const closeOnEscape = (e) => {
  if (open.value && e.key === 'Escape') {
    open.value = false
  }
}

onMounted(() => document.addEventListener('keydown', closeOnEscape))
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape))

const widthClass = computed(() => {
  return {
    '48': 'w-48',
  }[props.width.toString()]
})

const alignmentClasses = computed(() => {
  if (props.align === 'left') {
    return 'origin-top-left left-0'
  }

  if (props.align === 'right') {
    return 'origin-top-right right-0'
  }

  return 'origin-top'
})
</script>

<template>
  <div class="relative">
    <div @click="open = !open">
      <slot name="trigger"></slot>
    </div>

    <!-- Full Screen Dropdown Overlay -->
    <div v-show="open" class="fixed inset-0 z-40" @click="open = false"></div>

    <transition
      enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
      <div
        v-show="open" class="absolute z-50 my-2 rounded-md shadow-lg" :class="[widthClass, alignmentClasses]"
        style="display: none;" @click="open = false">
        <div class="rounded-md bg-base-200 ring-1 ring-neutral" :class="contentClasses">
          <slot name="content"></slot>
        </div>
      </div>
    </transition>
  </div>
</template>
