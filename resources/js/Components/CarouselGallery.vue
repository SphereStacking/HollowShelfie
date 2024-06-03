<script setup>
import SwiperWrapper from './Swiper/SwiperWrapper.vue'

const props = defineProps({
  images: {
    type: Array,
    default: () => [],
    required: true
  },
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
  <div class="flex h-full flex-col justify-between gap-2">
    <slot name="header"></slot>
    <div class="relative aspect-a4 min-h-80 " :class="[!props.images.length ? 'rounded-xl bg-base-300' : '']">
      <template v-if="props.images.length>0">
        <SwiperWrapper
          ref="swiper1"
          class="size-full" loop="true"
          space-between="10"
          :thumbs-swiper="`#${uniqueId}`"
          sc
          :model-value="images">
          <template #item="{element}">
            <FryerImg :src="element" />
          </template>
        </SwiperWrapper>
      </template>
      <template v-else>
        <div class="size-full bg-base-300">
          <IconTypeMapper type="imageOff" class=" absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2  text-6xl" />
        </div>
      </template>
    </div>

    <div class=" flex flex-row items-center justify-between gap-1">
      <button class="btn btn-square  btn-md" @click="prev">
        <IconTypeMapper type="arrowLeft" class="text-4xl" />
      </button>
      <SwiperWrapper
        :id="uniqueId"
        loop="true"
        free-mode="true"
        slides-per-view="3"
        :model-value="images"
        watch-slides-progress="true"
        scrollbar="true"
        class="w-32"
        @oninit="console.log('hoge')">
        <template #item="{element}">
          <FryerImg class="h-10" :src="element" />
        </template>
      </SwiperWrapper>

      <button class="btn btn-square  btn-md" @click="next">
        <IconTypeMapper type="arrowRight" class="text-4xl" />
      </button>
    </div>
    <slot name="footer"></slot>
  </div>
</template>

