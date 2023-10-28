<script setup>

</script>

<template>
  <div class="card w-96 bg-base-100 shadow-xl">
    <div class="card-body">
      <h2 class="card-title">
        <slot name="title"></slot>
      </h2>
      <slot name="content"></slot>
      <div class="card-actions justify-end">
        <slot name="actions"></slot>
      </div>
    </div>
  </div>
</template>

<style lang="">

</style>
