<script setup>
defineProps({
  status: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  }
})

</script>

<template>
  <div
    class="badge badge-sm text-nowrap rounded-full" :class="{
      'badge badge-outline': status == 'draft' || status == 'closed',
      'badge-info badge-outline': status == 'upcoming',
      'badge-warning badge-outline': status == 'unpublished' ,
      'badge-error badge-outline': status == 'forced_hidden',
      'badge-success badge-outline': status == 'ongoing',
    }">
    {{ label }}
  </div>
</template>

<style lang="">

</style>
