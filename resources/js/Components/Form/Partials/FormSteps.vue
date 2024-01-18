<script setup>

defineProps({
  name: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    required: true
  },
  elements: {
    type: Array,
    default: () => []
  },

})

const slotContentRef = ref(null)
const componentCount = ref(0)

onUpdated(() => {
  if (slotContentRef.value) {
    // スロットの子要素を数える
    const children = slotContentRef.value.children
    componentCount.value = children ? children.length : 0
  }
})
</script>

<template>
  <div ref="slotContentRef" class="w-full ">
    <ul class="timeline w-full justify-between ">
      <li class="w-aut">
        <div class="timeline-start">
          2001
        </div>
        <div class="timeline-middle">
          <Icon icon="mdi:checkbox-marked-circle" />
        </div>
        <hr class="bg-primary">
      </li>
      <li>
        <hr class="bg-primary">
        <div class="timeline-start">
          2007
        </div>
        <div class="timeline-middle">
          <Icon icon="mdi:checkbox-marked-circle" />
        </div>
        <hr>
      </li>
      <li>
        <hr>
        <div class="timeline-start">
          2015
        </div>
        <div class="timeline-middle">
          <Icon icon="mdi:checkbox-blank-circle-outline" />
        </div>
      </li>
    </ul>
    <slot></slot>
  </div>
</template>

<style lang="">
</style>
