<script setup>
import InputError from '@/Jetstream/InputError.vue'
import ProviderIcon from '@/Components/SocialstreamIcons/ProviderIcon.vue'

defineProps({
  prompt: {
    type: String,
    default: 'Or Login Via',
  },
  error: {
    type: String,
    default: null,
  },
  providers: {
    type: Array,
  },
  labels: {
    type: Object,
  }
})

const animationGhost = ref(null)
const onAnimate = () => {
  if (animationGhost.value) {
    animationGhost.value.animationStart()
  }
}
const animationDuration = 1000 // アニメーションの期間をミリ秒で設定

const goToLogin = (providerId) => {
  onAnimate()
  setTimeout(() => {
    window.location.href = route('oauth.redirect', providerId)
  }, animationDuration)
}

</script>

<template>
  <AnimationGhost ref="animationGhost" />

  <div v-if="providers.length" class="mb-2 mt-6 space-y-6">
    <div class="divider">
      {{ prompt }}
    </div>

    <InputError v-if="error" :message="error" class="text-center" />

    <div class="grid gap-4">
      <button
        v-for="provider in providers" :key="provider.id"
        class="btn btn-outline"
        @click="goToLogin(provider.id)">
        <ProviderIcon :provider="provider" classes="h-6 w-6 mx-2" />
        <span class="block text-sm font-medium ">{{ provider.buttonLabel || provider.name }}</span>
      </button>
    </div>
  </div>
</template>
