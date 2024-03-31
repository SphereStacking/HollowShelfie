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
    <div class="flex w-full justify-around rounded-xl bg-base-200 p-2">
      <a
        v-for="(performer, index ) in performers" :key="index" :href="performer.profile_url"
        class="avatar tooltip h-10 transition-all duration-200 hover:-translate-y-1" :data-tip="performer.name">
        <img :src="performer.image_url" class="h-10 rounded-md">
      </a>
    </div>
  </div>
</template>
<style>

</style>
