
<script setup>
const props = defineProps({
  event: {
    type: Object,
    required: true
  },
  profileId: {
    type: Number,
    required: true
  },
  profileType: {
    type: String,
    required: true
  }
})
const isOrganizer = computed(() => {
  return props.event.organizers.some(organizer => organizer.id === props.profileId && organizer.type === props.profileType)
})
const isPerformer = computed(() => {
  return props.event.performers.some(performer => performer.id === props.profileId && performer.type === props.profileType)
})
const badgeTexts = computed(() => {
  const texts = []
  if (isOrganizer.value) texts.push('主催')
  if (isPerformer.value) texts.push('演者')
  return texts.join('/')
})

</script>

<template>
  <div class="indicator size-full">
    <span
      class="badge indicator-item translate-x-0 text-primary-content"
      :class="{ 'bg-gradient-to-r  from-primary to-secondary': badgeTexts.length > 1 }">
      <template v-if="badgeTexts">{{ badgeTexts }}</template>
    </span>
    <CardEvent
      :event="event"
      class="size-full"
      scroll-region
      @share="modalEventShare.onBtnOpenModal(event)" />
  </div>
</template>

<style scoped>

</style>
