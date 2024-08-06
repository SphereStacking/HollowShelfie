<script setup lang="ts">
import { Performer } from './PerformerBadgeTypes'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'

type Props = {
  performer: Performer
  isSearching?: boolean
}

defineProps<Props>()

</script>

<template>
  <div
    class="btn btn-lg flex w-44 flex-row flex-nowrap items-center justify-start gap-2 rounded-md p-2 text-sm "
    :class="isSearching ? 'skeleton bg-base-200' : ''">
    <template v-if="performer.image_url">
      <img :src="performer.image_url" class="w-10 rounded-xl">
    </template>
    <template v-else-if="isSearching">
      <div class="rounded-xl bg-base-200">
        <div class="skeleton size-10"></div>
      </div>
    </template>
    <template v-else>
      <div class="rounded-xl bg-base-200">
        <IconTypeMapper type="unknownUser" class="skeleton size-10 p-2" />
      </div>
    </template>
    <div class="flex flex-col justify-start truncate text-left">
      <span class="truncate font-bold ">
        {{ performer.name }}
      </span>
      <span class="text-xs opacity-30">
        <template v-if="performer.screen_name">
          @{{ performer.screen_name }}
        </template>
      </span>
    </div>
  </div>
</template>
