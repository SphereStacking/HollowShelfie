<script setup>
defineProps({

})
defineEmits(
  ['click']
)
</script>
<template>
  <BtnBase class="btn btn-info btn-outline" @click="$emit('click')">
    <slot></slot>
  </BtnBase>
</template>
<style lang="">

</style>
