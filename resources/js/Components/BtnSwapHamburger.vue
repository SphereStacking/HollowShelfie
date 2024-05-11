<script setup>
const props = defineProps({
  check: {
    type: Boolean,
    required: true
  },
  count: {
    type: String,
    default: '?'
  },
})

const emit = defineEmits(['update:check'])

const updateCheck = (newCheck) => {
  emit('update:check', newCheck)
}
</script>
<template>
  <BtnSwapBase
    class="btn btn-square btn-ghost btn-active btn-sm"
    on-icon="close" off-icon="menu" swap-effect="rotate"
    :check="props.check" on-color="white text-xl" off-color="white text-xl"
    @update:check="updateCheck" />
</template>
<style>

</style>
