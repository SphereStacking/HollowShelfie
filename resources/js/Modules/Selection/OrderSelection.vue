<script setup>
defineProps({
  modelValue: {
    type: String,
    required: true
  }
})
const sortMaps = [
  { type: 'new', icon: 'new', label: 'new' },
  { type: 'good', icon: 'good', label: 'good' },
  { type: 'start_date', icon: 'eventUpcoming', label: '開催予定' },
  { type: 'created_at', icon: 'eventCreated', label: '作成日' },
]

const emit = defineEmits(['update:modelValue'])

const onSortChange = (sort) => {
  emit('update:modelValue', sort.type)
}
</script>
<template>
  <BtnDropdown class="dropdown-end" width="w-36">
    <template #trigger>
      <div class=" btn indicator  btn-sm w-16 px-2">
        <IconTypeMapper type="sortItem" class="text-xl transition-all" />
        <div v-if="sortMaps.find(sort => sort.type === modelValue)" class="badge indicator-item badge-info translate-x-2 px-1.5">
          <IconTypeMapper :type="sortMaps.find(sort => sort.type === modelValue).icon" class="text-sm" />
        </div>
      </div>
    </template>
    <BtnDropdownItem v-for="(sortItem, index) in sortMaps" :key="index">
      <div @click="onSortChange(sortItem)">
        <IconTypeMapper :type="sortItem.icon" class="text-xl transition-all" />
        {{ sortItem.label }}
      </div>
    </BtnDropdownItem>
  </BtnDropdown>
</template>
<style lang="">

</style>
