<script setup>

</script>

<template>
  <div class="card card-compact bg-base-200 shadow-xl">
    <slot name="top"></slot>
    <div class="card-body">
      <h2 class="card-title">
        <slot name="title"></slot>
      </h2>
      <slot></slot>
      <div class="card-actions justify-end">
        <slot name="actions"></slot>
      </div>
      <slot name="bottom"></slot>
    </div>
  </div>
</template>

<style lang="">

</style>
