<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

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
  isNavigate: {
    type: Boolean,
  },
  queryValueSetter: {
    type: Function,
    default: function (value) { return value; }
  },
  buttonTextSetter: {
    type: Function,
    default: function (value) { return value; }
  },
});

const emit = defineEmits(['remove']);
const removeCondition = () => {
  emit('remove');
};

const navigateToType = () => {
  if (props.isNavigate) {
    console.log(props.queryValueSetter)
    console.log(props.queryValueSetter(props.value))
    const value = props.queryValueSetter(props.value)
    console.log(value)
    router.visit(
      route('event.search.index',
        { t: '', q: [{ include: 'and', type: props.type, value: value.toString() }], o: '', }
      )
    );
  }
};
</script>

<template>
  <BtnConditionTypeMapper :type="type" @click="navigateToType()">
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
          {{ buttonTextSetter(value) }}
        </div>
      </div>
    </template>
    <template v-else>
      <IconSerchItemType v-if="isIcon" :type="type" class="text-lg"></IconSerchItemType>
      <Icon v-if="isClose" icon="line-md:close-small" class="text-lg" @click="removeCondition">
      </Icon>
      {{ buttonTextSetter(value) }}
    </template>
  </BtnConditionTypeMapper>
</template>
