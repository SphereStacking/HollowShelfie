<script setup>
defineProps({

})
defineEmits(
  ['click']
)
</script>
<template>
  <BtnBase class="btn btn-secondary btn-active" @click="$emit('click')">
    <slot></slot>
  </BtnBase>
</template>
<style lang="">

</style>
