<script setup>

defineProps({
  organizers: {
    type: Array,
    required: true
  }
})

</script>
<template>
  <div v-if="organizers.length > 0" class="flex w-full flex-col justify-center">
    <div class="flex flex-row items-center gap-1">
      <IconTypeMapper type="organizer" />
      <div>organizers</div>
    </div>
    <div class="flex w-full flex-wrap  justify-center gap-2 rounded-xl bg-base-200 p-2">
      <AvatarLink
        v-for="(organizer, index ) in organizers" :key="index" :href="organizer.profile_url"
        class="tooltip transition-all duration-200 hover:-translate-y-1" :data-tip="organizer.name"
        :image-url="organizer.image_url" :name="organizer.name" />
    </div>
  </div>
</template>
<style>

</style>
