<script setup>
import { ref } from 'vue';

const props = defineProps({
  value: {
    type: String,
    required: true
  },
  type: {
    type: String,
    required: true
  },
  isClose: {
    type: Boolean,
  },
  isIcon: {
    type: Boolean,
  },
});

const emit = defineEmits(['remove']);
const removeCondition = () => {
  emit('remove');
};

</script>

<template>
  <BtnConditionTypeMapper :type="type">
    <template v-if="isIcon && isClose">
      <div class="relative">
        <IconTypeMapper v-if="isIcon" :type="type"
          class="absolute top-0 left-0 text-lg transition-all duration-300 opacity-100 group-hover:opacity-0 ">
        </IconTypeMapper>
        <Icon icon="mdi:close"
          class="absolute top-0 left-0 text-lg transition-all duration-300 opacity-0 group-hover:opacity-100 -rotate-90 group-hover:rotate-0"
          @click="removeCondition">
        </Icon>
        <div class="pl-6">
          {{ value }}
        </div>
      </div>
    </template>
    <template v-else>
      <IconSerchItemType v-if="isIcon" :type="type" class="text-lg"></IconSerchItemType>
      <Icon v-if="isClose" icon="line-md:close-small" class="text-lg" @click="removeCondition">
      </Icon>
      {{ value }}
    </template>
  </BtnConditionTypeMapper>
</template>
