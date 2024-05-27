<script setup>
import { format } from 'date-fns'

const props = defineProps({
  value: {
    type: String,
    default: '',
  },
})

const type = 'date'

const formattedStartDate = computed(() => format(props.value.start, 'yyyy/MM/dd HH:mm'))
const formattedEndDate = computed(() => format(props.value.end, 'yyyy/MM/dd HH:mm'))
</script>

<template>
  <BtnConditionTypeMapper :type="type">
    <div class="relative">
      <IconTypeMapper
        :type="type"
        class="absolute left-0 top-1/2 -translate-y-1/2 text-lg opacity-100 transition-all duration-300 group-hover:opacity-0 " />
      <IconTypeMapper
        type="close"
        class="absolute left-0 top-1/2 -translate-y-1/2 -rotate-90 text-lg opacity-0 transition-all duration-300 group-hover:rotate-0 group-hover:opacity-100" />
      <div class="pl-6">
        {{ formattedStartDate }} ~ {{ formattedEndDate }}
      </div>
    </div>
  </BtnConditionTypeMapper>
</template>

