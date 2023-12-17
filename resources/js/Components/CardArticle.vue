<script setup>

</script>

<template>
  <article class="card card-compact bg-base-200 shadow-xl">
    <div class="card-body">
      <slot name="header"></slot>
      <h2 v-if="$slots.title" class="card-title">
        <slot name="title"></slot>
      </h2>
      <slot name="content"></slot>
      <div v-if="$slots.actions" class=" card-actions justify-end">
        <slot name="actions"></slot>
      </div>
    </div>
  </article>
</template>

<style lang="">

</style>
