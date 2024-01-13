<script setup>
defineProps({

})
defineEmits(
  ['click']
)
</script>
<template>
  <BtnBase class="btn btn-outline btn-info" @click="$emit('click')">
    <slot></slot>
  </BtnBase>
</template>
<style lang="">

</style>
