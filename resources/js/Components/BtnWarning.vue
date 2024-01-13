<script setup>
defineProps({
})
defineEmits(
  ['click']
)
</script>
<template>
  <BtnBase class="btn btn-outline btn-warning" @click="$emit('click')">
    <slot></slot>
  </BtnBase>
</template>
<style lang="">

</style>
