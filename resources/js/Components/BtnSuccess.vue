<script setup>
defineProps({
})
defineEmits(
  ['click']
)
</script>
<template>
  <BtnBase class="btn btn-outline btn-success" @click="$emit('click')">
    <slot></slot>
  </BtnBase>
</template>
<style lang="">

</style>
