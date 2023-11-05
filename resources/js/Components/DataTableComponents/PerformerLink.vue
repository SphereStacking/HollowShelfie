<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  data: String
});

const link = route('performer.show', props.data.id)
const name = props.data.name ?? 'noname'
const profile_photo_url = props.data.profile_photo_url
</script>

<template>
  <div class="flex flex-row items-center justify-between">
    <img :src="profile_photo_url" />
    <Link class="link" :href="link">{{ name }}</Link>
  </div>
</template>
