<script setup>
import GoogleIcon from '@/Components/SocialstreamIcons/GoogleIcon.vue'
import DiscordIcon from '@/Components/SocialstreamIcons/DiscordIcon.vue'

defineProps({
  provider: {
    type: Object,
    required: true,
  },
  classes: {
    type: String,
    default: () => 'w-6 h-6',
  }
})

const providerIconMap = {
  'google': GoogleIcon,
  'discord': DiscordIcon,
}

</script>

<template>
  <div class="text-gray-900 dark:text-gray-100">
    <component :is="providerIconMap[provider.id]" :class="classes" />
  </div>
</template>
