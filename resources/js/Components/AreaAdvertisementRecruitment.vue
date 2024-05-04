<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <Link
    :href="route('about', 'advertisement')"
    class="flex flex-row items-center justify-center rounded-lg border-2 border-dashed border-neutral bg-base-300 hover:bg-base-300/80">
    <div class="flex flex-row  p-2">
      広告募集！
    </div>
  </Link>
</template>
