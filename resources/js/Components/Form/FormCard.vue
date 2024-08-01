<script setup>
// NOTE:FormContainerを今後使用する。

const hasTitle = computed(() => !!useSlots().title)
const hasActions = computed(() => !!useSlots().actions)
const hasFooters = computed(() => !!useSlots().footer)

const formCardElement = ref(null)

const scrollToTop = () => {
  formCardElement.value.scrollIntoView({ behavior: 'smooth', block: 'start' })
}

defineExpose({ scrollToTop })

</script>

<template>
  <div ref="formCardElement" class="card card-compact bg-base-300 p-4 shadow-xl">
    <slot name="header"></slot>
    <div class="card-body gap-5">
      <h2 v-if="hasTitle" class="card-title">
        <slot name="title"></slot>
      </h2>

      <slot></slot>

      <div v-if="hasActions" class="card-actions justify-end">
        <slot name="actions"></slot>
      </div>

      <slot v-if="hasFooters" name="footer"></slot>
    </div>
  </div>
</template>

<style lang="">

</style>
