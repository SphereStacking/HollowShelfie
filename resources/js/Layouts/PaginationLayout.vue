<script setup>
defineProps({
  pagination: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <div class="mx-auto flex max-w-7xl flex-col gap-5">
    <div class="flex flex-row  justify-between">
      <div class="">
        {{ pagination.to }} / {{ pagination.total }}
      </div>
      <div class=" flex flex-row gap-2">
        <slot name="TopPaginationLeft"></slot>
        <BtnPagination
          :links="pagination.links" />
        <slot name="TopPaginationRight"></slot>
      </div>
    </div>
    <slot></slot>
    <div class="flex flex-row justify-center">
      <slot name="BottomPaginationLeft"></slot>
      <BtnPagination
        :links="pagination.links" />
      <slot name="BottomPaginationRight"></slot>
    </div>
  </div>
</template>
<style lang="">

</style>
