<script setup>
defineProps({
  items: {
    type: Array,
    required: true
  },
  addConditionFunc: {
    type: Function,
    required: true
  },
})
const isVisible = ref(false)

onMounted(() => {
  isVisible.value = true
})

onBeforeUnmount(() => {
  isVisible.value = false
})
</script>

<template>
  <Transition
    name="slide-up"
    tag="div"
    enter-active-class="transition-all duration-200"
    enter-from-class="opacity-0 translate-y-2"
    enter-to-class="opacity-100"
    leave-active-class=""
    leave-from-class="opacity-100"
    leave-to-class="opacity-0 translate-y-2">
    <div v-if="isVisible" class="flex flex-wrap gap-2">
      <BtnEventSearchItem
        v-for="item in items " :key="item" type="category"
        :value="item"
        @click="addConditionFunc({ type: 'category', value: item })" />
    </div>
  </Transition>
</template>
<style lang="">

</style>
