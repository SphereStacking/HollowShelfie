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
  count: {
    type: String,
    default: null
  },
  showCount: {
    type: Boolean,
  },
})

const removeUrl = route('event.ungood', props.eventId)
const addUrl = route('event.good', props.eventId)

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
  <BtnSwapGood
    :check="isCheck"
    :count="count"
    :show-count="showCount"
    @click="toggle">
    <slot></slot>
  </BtnSwapGood>
</template>
<style lang="">

</style>

