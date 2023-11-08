<script setup>
const props = defineProps({
  content: {
    type: String,
    required: true
  },
})
defineEmits(
  ['click']
)
</script>
<template>
  <Card class=" w-full 2xl:w-2/3">
    <div class="parse">
      <h4 class="text-xl text-gray-900 font-bold">About</h4>
      {{ content }}
    </div>
  </Card>
</template>
