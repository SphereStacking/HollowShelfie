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
    <div v-if="isVisible">
      <BaseConditionSuggestion
        placeholder="タグを検索"
        :url="route('tag.suggestion')"
        :add-condition-func="addConditionFunc">
        <template #items="{ suggestions }">
          <BtnEventSearchItem
            v-for="item in suggestions" :key="item" type="tag"
            :value="item.name"
            @click="addConditionFunc({ type: 'tag', value: item.name })" />
        </template>
        <div class="divider divider-start my-0 w-full">
          <div class="flex flex-row items-center  gap-1">
            <IconTypeMapper type="trend" class="text-xl" />
            trend
          </div>
        </div>
        <BtnEventSearchItem
          v-for="item in items" :key="item" type="tag"
          :value="item.name"
          @click="addConditionFunc({ type: 'tag', value: item.name })" />
      </BaseConditionSuggestion>
    </div>
  </Transition>
</template>
<style lang="">

</style>
