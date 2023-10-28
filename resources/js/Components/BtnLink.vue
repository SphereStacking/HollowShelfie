<script setup>
defineProps({
})
defineEmits(
  ['click']
)
</script>
<template>
  <BtnBase class="btn btn-link btn-active btn-xs px-0" @click="$emit('click')">
    <slot></slot>
  </BtnBase>
</template>
<style lang="">

</style>
