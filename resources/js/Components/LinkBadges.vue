<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
  tags: {
    type: Array,
    required: true
  },
  route:{
    type: String,
    required: true
  }
})

const serchTag = (tagName) => {
  router.get(props.route, { tags: [tagName] }, { replace: true, preserveState: true })
}

</script>

<template>
<div>
  <div v-for="tag in props.tags" :key="name" @click="serchTag(tag)"
    class="badge badge-ghost badge-md mr-1 hover:badge-outline">
    {{ tag }}
  </div>
</div>
</template>

<style lang="">

</style>
