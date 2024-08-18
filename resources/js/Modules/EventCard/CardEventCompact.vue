
<script setup>
import { Link, router} from '@inertiajs/vue3'

const props = defineProps({
  event: {
    type: Object,
    required: true
  },
})
const currentImageIndex = ref(0)

const incrementImageIndex = () => {
  if (props.event.files.length > 0) {
    currentImageIndex.value = (currentImageIndex.value + 1) % props.event.files.length
  }
}

</script>

<template>
  <div class=" flex flex-col justify-start border border-transparent">
    <div class="flex flex-col justify-start border border-transparent">
      <div class="relative aspect-a4 min-w-40 rounded-md bg-base-300" @click.prevent="incrementImageIndex">
        <template v-if="event.files.length>0">
          <TransitionGroup
            enter-active-class="transition-all duration-300"
            leave-active-class="transition-all duration-600"
            enter-from-class="translate-y-10 opacity-0"
            leave-to-class="-translate-y-10 opacity-0">
            <FlyerImg
              v-for="(image, index) in event.files" v-show="index === currentImageIndex"
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
          <div v-for="(instance, index) in event.files" :key="index">
            <div class="select-none">
              {{ index === currentImageIndex ? '•' : '-' }}
            </div>
          </div>
        </div>
      </div>
      <div class="mt-0.5 flex flex-row justify-between">
        <Link :href="route('event.show', event.alias)" class=" mx-2 truncate whitespace-nowrap text-xs font-bold transition-all duration-200 hover:text-accent hover:underline">
          {{ event.title }}
        </Link>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
