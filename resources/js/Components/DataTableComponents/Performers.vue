<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  data: Array
})

const performers = props.data.performers
const description = props.data.description
</script>

<template>
  <div>
    <div class="flex flex-row gap-2">
      <div v-for="performer in performers" class="w-1/3 bg-base-300">
        <Link class="link" :href="performer.profile_url">
          {{ performer.name }}
        </Link>
        <img :src="performer.image_url" class="h-24 rounded-md">
        <div class="flex gap-1">
          <a
            v-for="item in performer.links" class="felx-row link tooltip flex items-center gap-0.5" :data-tip="item.label"
            :href="item.link">
            <Icon icon="ph:link-bold" />
            <!-- {{ item.label }} -->
          </a>
        </div>
      </div>
    </div>
    {{ description }}
  </div>
</template>
