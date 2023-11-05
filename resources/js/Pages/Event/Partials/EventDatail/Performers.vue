<script setup>
defineProps({
  performers: {
    type: String,
    required: true
  },
  events: {
    type: Array,
    required: true
  },
})
</script>

<template>
  <DataTable :colum-defs="columDefs" :row-data="form.performers" />
</template>
