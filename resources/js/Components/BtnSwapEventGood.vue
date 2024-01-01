<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
  check: {
    type: Boolean,
    required: true
  },
  eventId: {
    type: Number,
    required: true
  },
  count: {
    type: String,
  },
  showCount: {
    type: Boolean,
  },
})

const removeUrl = route('event.ungood', props.eventId);
const addUrl = route('event.good', props.eventId);


const isCheck = ref(props.check);

const toggle = () => {
  if (props.check) {
    router.visit(
      removeUrl,
      {
        method: 'delete',
        preserveScroll: true,
      }
    )
  }else{
    router.visit(
      addUrl,
      {
        method: 'post',
        preserveScroll: true,
      }
    )
  }
}

</script>
<template>
  <BtnSwapGood
    @click="toggle"
    :check="isCheck"
    :count="count"
    :showCount="showCount"
    >
  </BtnSwapGood>
</template>
<style lang="">

</style>

