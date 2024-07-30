<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

type LinkType = {
  title: string
  routeUrl: string
  icon: string
  target?: string
  rel?: string
  discription?: string
}

defineProps({
  link: {
    type: Object as () => LinkType,
    required: true,
  },
  contentClass: {
    type: String,
    default: '',
  },
})

</script>
<template>
  <div class="group card card-side card-compact overflow-hidden shadow-md transition-transform duration-300 hover:scale-105">
    <div class="flex items-center justify-center bg-base-300 px-4">
      <IconTypeMapper :type="link.icon" class="shrink-0 text-4xl" />
    </div>
    <div class="flex size-full bg-base-200/50">
      <template v-if="link.target === '_blank'">
        <a
          :href="link.routeUrl" :target="link.target" :rel="link.rel"
          class="size-full">
          <div class="p-2" :class="contentClass">
            <div class="mb-1 p-0 text-lg font-bold group-hover:btn-link">
              {{ link.title }}
            </div>
            <slot name="discription">
              <div class="text-xs">
                {{ link.discription }}
              </div>
            </slot>
          </div>
        </a>
      </template>
      <template v-else>
        <Link :href="link.routeUrl" class="size-full">
          <div class="p-2" :class="contentClass">
            <div class="mb-1 p-0 text-lg font-bold group-hover:btn-link">
              {{ link.title }}
            </div>

            <slot name="discription">
              <div class="text-xs">
                {{ link.discription }}
              </div>
            </slot>
          </div>
        </Link>
      </template>
    </div>
  </div>
</template>
