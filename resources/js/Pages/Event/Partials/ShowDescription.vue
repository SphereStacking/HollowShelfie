<script setup>
import DOMPurify from 'isomorphic-dompurify'

const props = defineProps({
  description: {
    type: String,
    required: true
  }
})

const sanitizedDescription = ref('')

onMounted(() => {
  sanitizedDescription.value = DOMPurify.sanitize(props.description, {
    ADD_TAGS: ['iframe'],
    ADD_ATTR: ['allowfullscreen', 'autoplay', 'disablekbcontrols', 'enableiframeapi', 'endtime', 'ivloadpolicy', 'loop', 'modestbranding', 'origin', 'playlist', 'src', 'start']
  })
})
</script>
<template>
  <div class="flex w-full flex-col  justify-center">
    <div class="rounded-xl bg-base-200 p-5">
      <!-- eslint-disable-next-line vue/no-v-html -->
      <article class="prose prose-sm h-full sm:prose lg:prose-lg xl:prose-2xl" v-html="sanitizedDescription"></article>
    </div>
  </div>
</template>
<style>

</style>
