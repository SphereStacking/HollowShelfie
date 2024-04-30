<script setup lang="ts">
import { Performer } from '../EventTimeLineTypes'
import { Link } from '@inertiajs/vue3'

type Props = {
  performers: Performer[]
}

defineProps<Props>()

</script>
<template>
  <div class="flex w-full flex-col justify-center gap-2 rounded-md bg-base-300 p-1">
    <slot></slot>

    <!-- <Link
      v-for="performer in performers" :key="performer.id" :href="performer.profile_url"
      class="truncate text-nowrap text-center text-xs transition-all duration-200 hover:text-accent hover:underline ">
      {{ performer.name }}
    </Link>     -->
    <Link
      v-for="performer in performers" :key="performer.id" :href="performer.profile_url"
      class="truncate text-nowrap text-center text-xs transition-all duration-200 hover:text-accent hover:underline ">
      {{ performer.name }}
    </Link>
  </div>
</template>
