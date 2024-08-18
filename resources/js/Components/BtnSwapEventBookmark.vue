<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  check: {
    type: Boolean,
    required: true
  },
  eventId: {
    type: String,
    required: true
  },
})

const removeUrl = route('event.unbookmark', props.eventId)
const addUrl = route('event.bookmark', props.eventId)

const isCheck = ref(props.check)
const isLock=ref(false)
const toggle = () => {
  if (isLock.value) {
    return
  }
  isLock.value = true
  if (props.check) {
    router.visit(
      removeUrl,
      {
        method: 'delete',
        preserveScroll: true,
        preserveState: true,
        onFinish: () => {
          isLock.value = false
        }
      }
    )
  } else {
    router.visit(
      addUrl,
      {
        method: 'post',
        preserveScroll: true,
        preserveState: true,
        onFinish: () => {
          isLock.value = false
        }
      }
    )
  }
}

</script>
<template>
  <BtnSwapBookmark
    :check="isCheck"
    @click="toggle">
    <slot></slot>
  </BtnSwapBookmark>
</template>
<style lang="">

</style>
