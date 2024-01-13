<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  tags: {
    type: Array,
    required: true
  },
  route: {
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
    <div
      v-for="(tag, index) in props.tags" :key="index" class="badge badge-secondary badge-xs mr-1 rounded-md "
      @click="serchTag(tag)">
      {{ tag }}
    </div>
  </div>
</template>

<style lang="">

</style>
