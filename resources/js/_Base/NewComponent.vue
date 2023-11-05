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
    :id="id" class="btn btn-info btn-outline"
    @click="$emit('click')">
    <slot></slot>
  </BtnBase>
</template>
<style lang="">

</style>
