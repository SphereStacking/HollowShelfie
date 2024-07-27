<script setup>

const props = defineProps({
  modelValue: {
    type: String,
    required: true
  }
})

const directionMaps = [
  { type: 'default', icon: 'orderDefault', label: '標準' },
  { type: 'asc', icon: 'orderAsc', label: '昇順' },
  { type: 'desc', icon: 'orderDesc', label: '降順' },
]

const currentOrderDirection = computed(() => {
  return directionMaps.find(dir => dir.type === props.modelValue) || directionMaps[0]
})

const emit = defineEmits(['update:modelValue'])

const setOrderDirection = (type) => {
  currentOrderDirection.value = type
}

const onBtnOrderDirection = () => {
  const currentIndex = directionMaps.findIndex(
    dir => dir.type === currentOrderDirection.value.type
  )
  const nextIndex = (currentIndex + 1) % directionMaps.length
  setOrderDirection(directionMaps[nextIndex].type)
  emit('update:modelValue', directionMaps[nextIndex].type)
}

</script>
<template>
  <button class="btn btn-sm w-16" @click="onBtnOrderDirection()">
    <IconTypeMapper :type="currentOrderDirection.icon" class="text-xl transition-all" />
  </button>
</template>
<style lang="">

</style>
