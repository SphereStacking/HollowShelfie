<script setup>

</script>

<template>
  <div class="card card-compact bg-base-200 shadow-xl">
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
