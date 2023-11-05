<script setup>

</script>

<template>
  <article class="card bg-base-100 shadow-xl">
    <div class="card-body">
      <slot name="header"></slot>
      <h2 class="card-title">
        <slot name="title"></slot>
      </h2>
      <slot name="content"></slot>
      <div class="card-actions justify-end">
        <slot name="actions"></slot>
      </div>
    </div>
  </article>
</template>

<style lang="">

</style>
