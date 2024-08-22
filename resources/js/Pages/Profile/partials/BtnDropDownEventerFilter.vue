<script setup>

const props = defineProps({
  modelValue: {
    type: Array,
    default: () => [],
  },
})

const emit = defineEmits(['update:modelValue'])
const fileters= ref([
  {
    key: 'organizer',
    label: '主催',
    icon: 'organizer',
    active: false,
  },
  {
    key: 'performer',
    label: '演者',
    icon: 'performer',
    active: false,
  },
  // {
  //   key: 'upcoming',
  //   label: '開催予定',
  //   icon: 'eventUpcoming',
  //   active: false,
  // },
  // {
  //   key: 'close',
  //   label: 'クローズ',
  //   icon: 'close',
  //   active: false,
  // },
])

const updateFilter = (key) => {
  const filter = fileters.value.find(filter => filter.key === key)
  if (filter) {
    filter.active = !filter.active
  }
  emit('update:modelValue', fileters.value.filter(filter => filter.active).map(filter => filter.key))
}

onMounted(() => {
  fileters.value.forEach(filter => {
    filter.active = props.modelValue.includes(filter.key)
  })
  updateFilter()
})

</script>
<template>
  <BtnDropdown>
    <template #trigger>
      <button class="btn btn-neutral btn-sm">
        <IconTypeMapper type="filter" class="text-xl" />
      </button>
    </template>
    <BtnDropdownItem v-for="filter in fileters" :key="filter.key">
      <button class="btn btn-sm w-32 justify-start transition-all duration-300" @click="updateFilter(filter.key)">
        <IconTypeMapper :type="filter.icon" class="text-xl" :class="filter.active ? 'text-primary':'text-neutral'" />
        {{ filter.label }}
      </button>
    </BtnDropdownItem>
  </BtnDropdown>
</template>
