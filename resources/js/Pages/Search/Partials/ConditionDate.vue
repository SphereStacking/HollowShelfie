<script setup>
import dayjs from 'dayjs'

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

const searchDateText = ref('')
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
    <div
      v-if="isVisible"
      class="flex flex-wrap gap-2">
      <div class="join w-full">
        <PickerDateRange
          v-model="searchDateText" class="join-item "
          input-classes="input input-sm input-bordered z-20" />
        <button
          class="btn join-item btn-neutral btn-sm flex flex-row gap-2 "
          @click="addConditionFunc({ type: 'date', value: searchDateText })">
          Add
        </button>
      </div>
      <BtnEventSearchItem
        type="date" value="今日"
        @click="addConditionFunc({ type: 'date', value: dayjs().format('YYYY-MM-DD') })" />
      <BtnEventSearchItem
        type="date" value="今週"
        @click="addConditionFunc({ type: 'date', value: dayjs().startOf('week').format('YYYY-MM-DD') + ' ~ ' + dayjs().endOf('week').format('YYYY-MM-DD') })" />
      <BtnEventSearchItem
        type="date" value="今月"
        @click="addConditionFunc({ type: 'date', value: dayjs().startOf('month').format('YYYY-MM-DD') + ' ~ ' + dayjs().endOf('month').format('YYYY-MM-DD') })" />
    </div>
  </Transition>
</template>
<style lang="">

</style>
