<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  images: {
    type: Array,
    required: true
  },
  url: {
    type: String,
    required: true
  }
})

const currentImageIndex = ref(0)

const imageUrls = computed(() => {
  return props.images.map((image) => image.public_url)
})

</script>
<template>
  <div class="group relative aspect-a4 min-w-40 rounded-md bg-base-300 shadow-md transition-all duration-300 hover:cursor-pointer hover:shadow-lg hover:shadow-neutral-500">
    <ModalImagesViewer :images="imageUrls" :zoomble="true" />
    <template v-if="images.length>0">
      <TransitionGroup
        enter-active-class="transition-all duration-300"
        leave-active-class="transition-all duration-100"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0">
        <Link
          v-for="(image, index) in images" v-show="index === currentImageIndex" :key="index"
          :href="url">
          <FryerImg
            :key="index"
            class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 scale-90 cursor-pointer select-none"
            :src="image.public_url" />
        </Link>
      </TransitionGroup>
    </template>
    <template v-else>
      <div class="size-full bg-base-300">
        <IconTypeMapper type="imageOff" class="absolute left-1/2 top-1/2 aspect-a4 -translate-x-1/2 -translate-y-1/2 text-6xl" />
      </div>
    </template>
  </div>
</template>
