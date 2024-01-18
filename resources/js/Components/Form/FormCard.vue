<script setup>

</script>

<template>
  <div class="card card-compact bg-base-200 p-4 shadow-xl">
    <slot name="header"></slot>
    <div class="card-body gap-5">
      <h2 v-if="$slots.title" class="card-title">
        <slot name="title"></slot>
      </h2>
      <slot></slot>
      <div v-if="$slots.actions" class="card-actions justify-end">
        <slot name="actions"></slot>
      </div>
      <slot v-if="$slots.footer" name="footer"></slot>
    </div>
  </div>
</template>

<style lang="">

</style>
