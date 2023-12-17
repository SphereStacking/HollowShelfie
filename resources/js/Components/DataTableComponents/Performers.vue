<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  data: Array
});

const performers = props.data.performers
const description = props.data.description
</script>

<template>
  <div>
    <div class="flex flex-row gap-2">
      <div class="bg-base-300 w-1/3" v-for="performer in performers">
        <Link class="link" :href="performer.profile_url">{{ performer.name }}</Link>
        <img :src="performer.image_url" class="h-24 rounded-md" />
        <div class="flex gap-1">
          <a class="link flex felx-row items-center gap-0.5 tooltip" :data-tip="item.label" :href="item.link"
            v-for="item in performer.links">
            <Icon icon="ph:link-bold"></Icon>
            <!-- {{ item.label }} -->
          </a>
        </div>
      </div>
    </div>
    {{ description }}
  </div>
</template>
