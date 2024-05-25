<script setup>

defineProps({
  performers: {
    type: Array,
    required: true
  }
})

</script>
<template>
  <div v-if="performers.length > 0" class="flex w-full flex-col justify-center">
    <div class="flex flex-row items-center gap-1">
      <IconTypeMapper type="performer" />
      <div>performers</div>
    </div>
    <div class="flex w-full flex-wrap justify-center gap-2 rounded-xl bg-base-200 p-2">
      <AvatarLink
        v-for="(performer, index ) in performers" :key="index" :href="performer.profile_url"
        size="size-10"
        :image-url="performer.image_url" :name="performer.name" />
    </div>
  </div>
</template>
<style>

</style>
