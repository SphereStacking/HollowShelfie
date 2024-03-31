<script setup>
defineProps({
  items: {
    type: Array,
    required: true
  },
  type: {
    type: String,
    required: true
  },
  addConditionFunc: {
    type: Function,
    required: true
  }
})

defineEmits(['addCondition'])
</script>

<template>
  <div class="flex flex-wrap gap-2">
    <BtnEventSearchItem
      v-for="item in items " :key="item" :type="type"
      :value="item"
      @click="addConditionFunc({ type: type, value: item })" />
  </div>
</template>
<style lang="">

</style>
