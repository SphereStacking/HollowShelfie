<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  data: Array
});

const performers = props.data.performers
</script>

<template>
  <div>
    <div class=" bg-base-300 m-2" v-for="performer in performers">
      <Link class="link" :href="performer.profile_url">{{ performer.name }}</Link>
      <img :src="performer.image_url" class="h-24 rounded-md" />
      <div class="flex flex-col gap-1">
        <a class="link flex felx-row items-center gap-0.5" :href="item.link" v-for="item in performer.links">
          <Icon icon="ph:link-bold"></Icon>
          {{ item.label }}
        </a>
      </div>
    </div>
  </div>
</template>
