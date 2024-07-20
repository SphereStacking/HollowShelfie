<script setup>
import IconTypeMapper from '@/Components/IconTypeMapper.vue'

const modalEventShare = ref(null)
const props = defineProps({
  events: {
    type: Array,
    required: true,
  },
})

const hasEvents = computed(() => {
  return props.events.data.length > 0
})

</script>
<template>
  <div v-if="hasEvents">
    <ModalEventShareConfirm ref="modalEventShare" />
    <div class="divider divider-end mt-5 w-full text-2xl font-bold">
      <div>
        <IconTypeMapper type="event" />
      </div>
      <h4 class="font-bold">
        Events
      </h4>
    </div>
    <div class="my-2 grid w-full grid-cols-2  gap-6 sm:grid-cols-3  md:grid-cols-4 xl:grid-cols-6">
      <CardEvent
        v-for="(item, index) in props.events.data"
        :key="index" :event="item"
        scroll-region
        @share="modalEventShare.onBtnOpenModal(item)" />
    </div>
  </div>
</template>
<style scoped>

</style>
