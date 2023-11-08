<script setup>
const props = defineProps({
  events: {
    type: String,
    required: true
  },
})
defineEmits(
  ['click']
)
</script>
<template>
  <Card>
    <div class="flex items-center justify-between">
      <h4 class="text-xl text-gray-900 font-bold">出演予定</h4>
    </div>
    <!-- <CardEvent>
    </CardEvent> -->
  </Card>
</template>
