<script setup>
defineProps({
})
defineEmits(
  ['click']
)
</script>
<template>
  <BtnBase class="btn btn-warning btn-outline" @click="$emit('click')">
    <slot></slot>
  </BtnBase>
</template>
<style lang="">

</style>
