<script setup>
import { useMounted } from '@vueuse/core'

const isMounted = useMounted()
defineProps({
  images: {
    type: Array,
    required: true,
  },
  zoomble: {
    type: Boolean,
    default: false,
  },
})

const show = ref(false)
</script>
<template lang="">
  <template v-if="isMounted && zoomble">
    <teleport to="body">
      <Modal v-model:show="show" @close="show = false">
        <SwiperWrapper
          loop="true"
          space-between="2"
          scrollbar="true"
          :zoom="true"
          slide-class="mb-4"
          :model-value="images">
          <template #item="{element}">
            <div class="swiper-zoom-container">
              <img :src="element">
            </div>
          </template>
        </SwiperWrapper>
      </Modal>
    </teleport>
    <div class="absolute right-1 top-1 z-50 hidden flex-col items-center justify-center gap-0.5 group-hover:flex">
      <div class="tooltip tooltip-left" data-tip="zoom">
        <button class="btn btn-square btn-accent btn-sm" @click="show = true">
          <IconTypeMapper type="zoomPlus" class="size-8 p-1  text-accent-content " />
        </button>
      </div>
    </div>
  </template>
</template>
<style lang="">

</style>
