<script setup>
defineProps({
  items: {
    type: Array,
    required: true
  },
  addConditionFunc: {
    type: Function,
    required: true
  },
})
const isVisible = ref(false)

onMounted(() => {
  isVisible.value = true
})

onBeforeUnmount(() => {
  isVisible.value = false
})
</script>

<template>
  <Transition
    name="slide-up"
    tag="div"
    enter-active-class="transition-all duration-200"
    enter-from-class="opacity-0 translate-y-2"
    enter-to-class="opacity-100"
    leave-active-class=""
    leave-from-class="opacity-100"
    leave-to-class="opacity-0 translate-y-2">
    <AddConditionSuggestion
      v-if="isVisible"
      :items="items"
      placeholder="オーガナイザーid検索"
      :url="route('mention.suggestion')">
      <template #items="{ suggestions }">
        <PerformerBadge
          v-for="(item, index ) in suggestions"
          :key="index" :performer="item"
          class="tooltip transition-all duration-200 hover:-translate-y-1"
          @click="addConditionFunc({ type: 'organizer', value: item.screen_name })" />
      </template>
    </AddConditionSuggestion>
  </Transition>
</template>
<style lang="">

</style>
