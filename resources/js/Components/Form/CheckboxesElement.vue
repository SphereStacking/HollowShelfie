<script setup>
defineProps({
  id: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    required: true
  },
  discription: {
    type: String,
    required: true
  },
  modelValue: {
    type: String,
    default: ''
  },
  items: {
    type: Array,
    required: true
  },
  help: {
    type: String,
    default: null
  },
  error: {
    type: String,
    default: null
  },
  warning: {
    type: String,
    default: null
  },
})

const InputType = 'checkbox'
const emit = defineEmits(['update:modelValue'])

const updateValue = (e) => {
  // 子要素のmodelValueをe.target.valueでupdate
  emit('update:modelValue', e.target.value)
}
</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :warning="warning">
    <div class="grid w-full grid-cols-2 gap-2">
      <label
        v-for="item in items" :key="item.id" class=" cursor-pointer">
        <input
          :type="InputType"
          :checked="modelValue"
          class="checkbox mr-2 bg-transparent"
          @change="updateValue">
        <span class="label-text">{{ item.label }}</span>
      </label>
    </div>
  </Wrapper>
</template>

<style lang="">
</style>
