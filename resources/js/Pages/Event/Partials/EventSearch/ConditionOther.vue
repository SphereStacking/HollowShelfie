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
    <div v-if="isVisible" class="flex flex-col gap-2">
      <div class="divider divider-start my-0 w-full">
        <div class="flex flex-row items-center  gap-1">
          <IconTypeMapper type="status" class="text-xl" />
          status
        </div>
      </div>
      <div class="flex flex-wrap gap-2">
        <BtnEventSearchItem
          v-for="item in items.statuses " :key="item" type="status"
          :value="$t(item)"
          @click="addConditionFunc({ type: 'status', value: item })" />
      </div>
      <div class="divider divider-start my-0 mt-2 w-full">
        <div class="flex flex-row items-center  gap-1">
          <IconTypeMapper type="instance" class="text-xl" />
          instance
        </div>
      </div>
      <div class="flex flex-wrap gap-2">
        <BtnEventSearchItem
          v-for="item in items.instanceTypes " :key="item" type="instance"
          :value="item"
          @click="addConditionFunc({ type: 'instance', value: item })" />
      </div>
      <div class="divider divider-start my-0 mt-2 w-full">
        <div class="flex flex-row items-center  gap-1">
          <IconTypeMapper type="follow" class="text-xl" />
          follow
        </div>
      </div>
      <div class="flex flex-wrap gap-2">
        <BtnEventSearchItem
          type="follow"
          value="フォロー(主催者)"
          @click="addConditionFunc({ type: 'follow', value: 'organizers' })" />
        <BtnEventSearchItem
          type="follow"
          value="フォロー(演者)"
          @click="addConditionFunc({ type: 'follow', value: 'performers' })" />
      </div>
    </div>
  </Transition>
</template>
<style lang="">

</style>
