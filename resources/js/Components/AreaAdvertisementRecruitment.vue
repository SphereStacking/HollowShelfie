<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  link: {
    type: String,
    default: () => route('about', 'advertisement'),
  },
  as: {
    type: [String, Object],
    default: Link,
  },
})
</script>

<template>
  <component
    :is="as" :href="link" target="_blank"
    class=" relative flex flex-row items-center justify-center rounded-lg border-2 border-dashed border-neutral bg-base-300 hover:bg-base-300/80">
    <div class="absolute bottom-0 right-0  bg-accent px-2 opacity-70">
      <span class=" text-sm font-bold  text-accent-content">広告</span>
    </div>
    <slot>
      <div class="flex flex-row  p-2">
        広告募集！
      </div>
    </slot>
  </component>
</template>
