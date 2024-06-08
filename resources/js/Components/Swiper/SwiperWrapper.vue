<script setup>
import { ref, onMounted } from 'vue'
import { register } from 'swiper/element/bundle'
register()

const props = defineProps({
  modelValue: {
    type: Array,
    required: true,
  },
  slideClass: {
    type: String,
    default: '',
  },
  swiperParams: {
    type: Object,
    default: () => ({}),
  },
  hideNoImage: {
    type: Boolean,
  },
})

const swiperEl = ref(null)
const swiperApi = ref(null)

onMounted(() => {
  const defaultParams = {
    on: {
      init() { },
    },
  }
  const mergedParams = { ...defaultParams, ...props.swiperParams }
  Object.assign(swiperEl.value, mergedParams)
  swiperEl.value.initialize()
  swiperApi.value = swiperEl.value.swiper
})

watch(() => props.modelValue, () => {
  swiperApi.value.update()
  swiperApi.value.updateSlides()
})

defineExpose({
  swiperApi, swiperEl
})
</script>

<template>
  <swiper-container
    ref="swiperEl"
    class="custom-swiper grid size-full"
    init="false">
    <!-- eslint-disable-next-line vue/no-deprecated-slot-attribute -->
    <div v-if="$slots.before" slot="container-start">
      <slot name="before"></slot>
    </div>
    <!-- eslint-disable-next-line vue/no-deprecated-slot-attribute -->
    <div v-if="$slots.after" slot="container-end">
      <slot name="after"></slot>
    </div>
    <template v-for="(element, index) in modelValue" :key="index">
      <swiper-slide :class="slideClass" class="min-w-0">
        <slot name="item" :element="element" :index="index"></slot>
      </swiper-slide>
    </template>
    <template v-if="modelValue.length === 0 && !hideNoImage">
      <swiper-slide :class="slideClass" class="min-w-0">
        <slot name="no-image">
          <div class="size-full min-h-20 rounded-xl bg-base-300">
            <IconTypeMapper type="imageOff" class=" absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2  text-6xl" />
          </div>
        </slot>
      </swiper-slide>
    </template>
  </swiper-container>
</template>

<style scoped>
.custom-swiper {
  --swiper-navigation-color: oklch(var(--a));
  --swiper-pagination-color: oklch(var(--a));
  --swiper-pagination-bullet-inactive-color: oklch(var(--a));
  --swiper-scrollbar-drag-bg-color: oklch(var(--a));
}

</style>
