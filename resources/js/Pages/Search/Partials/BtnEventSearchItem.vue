<script setup>
import { router } from '@inertiajs/vue3'

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
  querySetter: {
    type: Function,
    default: function (value, type) {
      return [
        { include: 'and', type: type.toString(), value: value.toString() },
      ]
    }
  },
  buttonTextSetter: {
    type: Function,
    default: function (value) { return value }
  },
})

const emit = defineEmits(['remove'])
const removeCondition = () => {
  emit('remove')
}

const navigateToType = () => {
  if (!props.isNavigate) {return}
  const value = props.querySetter(props.value, props.type)
  router.visit(
    route('event.search.index',
      { t: '', q: value, o: '', }
    )
  )
}
</script>

<template>
  <BtnConditionTypeMapper :type="type" @click="navigateToType()">
    <template v-if="isIcon && isClose">
      <slot name="icon">
        <div class="relative">
          <IconTypeMapper
            v-if="isIcon" :type="type"
            class="absolute left-0 top-0 text-lg opacity-100 transition-all duration-300 group-hover:opacity-0 " />
          <IconTypeMapper
            type="close"
            class="absolute left-0 top-0 -rotate-90 text-lg opacity-0 transition-all duration-300 group-hover:rotate-0 group-hover:opacity-100"
            @click="removeCondition" />
          <div class="pl-6">
            {{ buttonTextSetter(value) }}
          </div>
        </div>
      </slot>
    </template>
    <template v-else>
      <slot name="content">
        <IconTypeMapper v-if="isIcon" :type="type" class="text-lg" />
        <Icon
          v-if="isClose" icon="line-md:close-small" class="text-lg"
          @click="removeCondition" />
        {{ buttonTextSetter(value) }}
      </slot>
    </template>
  </BtnConditionTypeMapper>
</template>
