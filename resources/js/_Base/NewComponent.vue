<script setup>
defineProps({
  id: {
    type: String,
    required: true
  },
})
defineEmits(
  ['click']
)
</script>
<template>
  <BtnBase
    :id="id" class="btn btn-outline btn-info"
    @click="$emit('click')">
    <slot></slot>
  </BtnBase>
</template>
<style lang="">

</style>
