<script setup>

const props = defineProps({
  images: {
    type: Array,
    required: true
  },
})

const currentImageIndex = ref(0)

const incrementImageIndex = () => {
  if (props.images.length > 0) {
    currentImageIndex.value = (currentImageIndex.value + 1) % props.images.length
  }
}

</script>
<template>
  <div class=" relative aspect-a4 min-w-40 rounded-md bg-base-300 shadow-md shadow-base-200" @click.prevent="incrementImageIndex">
    <template v-if="images.length>0">
      <TransitionGroup
        enter-active-class="transition-all duration-300"
        leave-active-class="transition-all duration-100"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0">
        <FryerImg
          v-for="(image, index) in images" v-show="index === currentImageIndex"
          :key="index"
          class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 scale-90 cursor-pointer select-none"
          :src="image.public_url" />
      </TransitionGroup>
    </template>
    <template v-else>
      <div class="size-full bg-base-300">
        <IconTypeMapper type="imageOff" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-6xl" />
      </div>
    </template>
    <div class="absolute bottom-0 left-1 flex w-full justify-start gap-1">
      <div v-for="(instance, index) in images" :key="index">
        <div class="select-none">
          {{ index === currentImageIndex ? '•' : '-' }}
        </div>
      </div>
    </div>
  </div>
</template>
