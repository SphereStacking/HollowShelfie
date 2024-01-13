<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  data: String
})

const link = route('performer.show', props.data.id)
const name = props.data.name ?? 'noname'
</script>

<template>
  <Link class="link" :href="link">
    {{ name }}
  </Link>
</template>
