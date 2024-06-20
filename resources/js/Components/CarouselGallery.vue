<script setup>
import SwiperWrapper from './Swiper/SwiperWrapper.vue'

defineProps({
  images: {
    type: Array,
    default: () => [],
    required: true
  },
  zoomble: {
    type: Boolean,
    default: false
  }
})

const swiper1 = ref(null)

const next = () => {
  swiper1.value.swiperApi.slideNext()
}

const generateUniqueId = () => {
  const timestamp = Date.now().toString(36)
  const randomString = Math.random().toString(36).substring(2, 15)
  return `id-${timestamp}-${randomString}`
}
const uniqueId = generateUniqueId()

const prev = () => {
  swiper1.value.swiperApi.slidePrev()
}
</script>

<template>
  <div class="group relative flex flex-col gap-4 overflow-hidden ">
    <template v-if="zoomble">
      <ModalImagesViewer :images="images" :zoomble="zoomble" />
    </template>
    <slot name="header"></slot>
    <SwiperWrapper
      ref="swiper1"
      loop="true"
      space-between="2"
      scrollbar="true"
      autoplay-delay="2500"
      slide-class="mb-4"
      :thumbs-swiper="`#${uniqueId}`"
      :model-value="images">
      <template #item="{element}">
        <FryerImg :src="element" />
      </template>
    </SwiperWrapper>

    <div class="flex items-center">
      <button class="btn btn-square btn-sm" @click="prev">
        <IconTypeMapper type="arrowLeft" class="text-3xl" />
      </button>
      <SwiperWrapper
        :id="uniqueId"
        class="mx-2 grow "
        loop="true"
        space-between="2"
        slides-per-view="4"
        hide-no-image="true"
        :model-value="images">
        <template #item="{element}">
          <FryerImg class="w-10" :src="element" />
        </template>
      </SwiperWrapper>
      <button class="btn btn-square btn-sm" @click="next">
        <IconTypeMapper type="arrowRight" class="text-3xl" />
      </button>
    </div>
    <slot name="footer"></slot>
  </div>
</template>

