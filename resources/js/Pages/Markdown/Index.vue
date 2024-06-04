<script setup>
import DOMPurify from 'isomorphic-dompurify'

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  content: {
    type: String,
    required: true
  },
})
defineEmits(
  ['click']
)

const sanitizedContent = DOMPurify.sanitize(props.content)
</script>
<template>
  <AppLayout :title="title">
    <div class="my-6  max-w-7xl">
      <!-- eslint-disable-next-line vue/no-v-html -->
      <div class="prose mx-auto" v-html="sanitizedContent"></div>
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
