<script setup>
import IconTypeMapper from '../IconTypeMapper.vue'

const hasTitle = computed(() => !!useSlots().title)
const hasActions = computed(() => !!useSlots().actions)
const hasFooters = computed(() => !!useSlots().footer)

const formCardElement = ref(null)

defineProps({
  isNext: {
    type: Boolean,
    default: false,
  },
  isPrev: {
    type: Boolean,
    default: false,
  },
  prevStep: {
    type: Function,
    required: true,
  },
  nextStep: {
    type: Function,
    required: true,
  },
  isNoStep: {
    type: Boolean,
    default: false,
  },
  isFirst: {
    type: Boolean,
    default: false,
  },
  isLast: {
    type: Boolean,
    default: false,
  },
})

const scrollToTop = () => {
  formCardElement.value.scrollIntoView({ behavior: 'smooth', block: 'start' })
}

defineExpose({ scrollToTop })

</script>

<template>
  <div
    ref="formCardElement" class="card card-compact bg-base-300 p-4 shadow-xl"
    :class="[
      isNoStep && isFirst ? 'rounded-b-none' : '',
      isNoStep && isLast ? 'rounded-t-none' : '',
      isNoStep && !isFirst && !isLast ? 'rounded-none' : ''
    ]">
    <slot name="header"></slot>
    <div class="card-body gap-5">
      <h2 v-if="hasTitle" class="card-title">
        <slot name="title"></slot>
      </h2>
      <slot></slot>
      <div v-if="!isNoStep||isLast" class="card-actions mt-5 justify-between">
        <slot
          name="actions" :is-next="isNext" :is-prev="isPrev"
          :prev-step="prevStep" :next-step="nextStep">
          <span class="w-24">
            <button v-if="isPrev" class="btn btn-primary btn-sm" @click="prevStep()">
              <IconTypeMapper type="arrowLeft" class="text-xl" />
              Prev
            </button>
          </span>
          <div class="flex grow justify-center">
            <slot name="center-action">
            </slot>
          </div>
          <span class="w-24">
            <button v-if="isNext" class="btn btn-primary btn-sm " @click="nextStep()">
              Next
              <IconTypeMapper type="arrowRight" class="text-xl" />
            </button>
          </span>
        </slot>
      </div>
      <slot v-if="hasFooters" name="footer"></slot>
    </div>
  </div>
</template>

<style lang="">

</style>
