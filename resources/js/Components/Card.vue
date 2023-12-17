<script setup>

</script>

<template>
  <div class="card card-compact bg-base-200 shadow-xl">
    <template v-if="$slots.header">
      <slot name="header"></slot>
    </template>
    <div class="card-body">
      <template v-if="$slots.title">
        <h2 class="card-title">

          <slot name="title"></slot>
        </h2>
      </template>
      <template v-if="$slots.default">
        <slot></slot>
      </template>
      <template v-if="$slots.actions">

        <div class="card-actions justify-end">
          <slot name="actions"></slot>
        </div>

      </template>
      <template v-if="$slots.footer">
        <slot name="footer"></slot>
      </template>
    </div>
  </div>
</template>

<style lang="">

</style>
