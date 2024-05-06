<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <Link :href="route('welcome')">
    <ApplicationMark v-bind="$attrs" />
  </Link>
</template>
