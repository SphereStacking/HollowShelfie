<script setup lang="ts">
import { Performer } from './PerformerBadgeTypes'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'

type Props = {
  performer: Performer
  isSearching: boolean
  isHoverHideingAnimation: boolean
}

defineProps<Props>()

</script>

<template>
  <div
    class="group btn btn-lg flex flex-row flex-nowrap items-center justify-start gap-0 rounded-md p-2 text-sm "
    :class="isSearching ? 'skeleton bg-base-200' : ''">
    <template v-if="performer.image_url">
      <img :src="performer.image_url" class="w-10 rounded-xl">
    </template>
    <template v-else>
      <div class=" rounded-xl bg-base-200">
        <IconTypeMapper type="unknownUser" class=" size-10 p-2" />
      </div>
    </template>
    <div
      class="flex flex-col justify-start text-left"
      :class="isHoverHideingAnimation ? 'group-hover:ml-2 delay-150 transition-all duration-200 group-hover:opacity-100 opacity-0 w-0 group-hover:w-32' : ''">
      <div class="truncate font-bold">
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
