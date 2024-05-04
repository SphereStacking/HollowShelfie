<script setup>
import {defineProps} from 'vue'
import ProviderIcon from '@/Components/SocialstreamIcons/ProviderIcon.vue'

const props = defineProps({
  provider: {
    type: Object
  },
  createdAt: {
    type: String,
    default: null,
  }
})
</script>

<template>
  <div>
    <div class="flex items-center justify-between px-3">
      <div class="flex items-center">
        <ProviderIcon :provider="provider" classes="h-6 w-6 me-2" />

        <div class="ml-2">
          <div class="font-sgmibold text-sm text-base-content">
            {{ provider.name }}
          </div>

          <div v-if="createdAt !== null" class="text-xs text-base-content">
            Connected {{ createdAt }}
          </div>

          <div v-else class="text-xs text-base-content">
            Not connected.
          </div>
        </div>
      </div>

      <slot name="action"></slot>
    </div>
  </div>
</template>
