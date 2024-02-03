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
  labelIconType: {
    type: String,
    default: ''
  },
  modelValue: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: ''
  },
  help: {
    type: String,
    default: null
  },
  error: {
    type: String,
    default: null
  },
  selectableItems: {
    type: Array,
    default: ()=>[]
  }

})

const InputType = 'text'

const emit = defineEmits(['update:modelValue'])

const updateValue = (e) => {
  // 子要素のmodelValueをe.target.valueでupdate
  emit('update:modelValue', e.target.value)
}
</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :label-icon-type="labelIconType">
    <div class="join grow">
      <slot name="joinLeft"></slot>
      <select
        v-bind="$attrs"
        class="join-item select select-sm  rounded-md py-0.5" :value="modelValue"
        :class="{ 'select-error': error }" @input="updateValue">
        <option disabled selected>
          Pick one
        </option>
        <option v-for="item in selectableItems" :key="item">
          {{ item }}
        </option>
      </select>
      <slot name="joinRight"></slot>
    </div>
  </Wrapper>
</template>

<style lang="">
</style>
