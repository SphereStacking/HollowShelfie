<script setup>
defineProps({

})
defineEmits(
  ['click']
)
</script>
<template>
  <BtnBase class="btn btn-primary btn-active" @click="$emit('click')">
    <slot></slot>
  </BtnBase>
</template>
<style lang="">

</style>
