<script setup>
const props = defineProps({
  data: String
})

const profile_photo_url = props.data.profile_photo_url
</script>

<template>
  <img :src="profile_photo_url" class="h-24 rounded-md">
</template>
