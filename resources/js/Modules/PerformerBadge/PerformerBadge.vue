<script setup lang="ts">
import { Performer } from './PerformerBadgeTypes'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'

type Props = {
  performer: Performer
}

defineProps<Props>()

</script>

<template>
  <div class="btn btn-lg flex w-44 flex-row items-center justify-start gap-2 rounded-md p-2 text-sm">
    <template v-if="performer.image_url">
      <img :src="performer.image_url" class="w-10 rounded-xl">
    </template>
    <template v-else>
      <div class=" rounded-xl bg-base-200">
        <IconTypeMapper type="unknownUser" class="size-10 p-2" />
      </div>
    </template>
    <div class="flex flex-col justify-start text-left ">
      <div class="truncate font-bold ">
        {{ performer.name }}
      </div>
      <div class="text-xs opacity-30">
        <template v-if="performer.screen_name">
          @{{ performer.screen_name }}
        </template>
      </div>
    </div>
  </div>
</template>
