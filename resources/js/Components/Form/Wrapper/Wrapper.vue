<script setup>
import {computed} from 'vue'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'

const props = defineProps({
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
  isRequired: {
    type: Boolean,
    default: false
  },
  error: {
    type: String,
    default: null
  },
  warning: {
    type: String,
    default: null
  },
  type: {
    type: String,
    default: 'text'
  }
})

const emit = defineEmits(['update:modelValue'])

const updateValue = (e) => {
  // 子要素のmodelValueをe.target.valueでupdate
  emit('update:modelValue', e.target.value)
}

const hasLabelIconType = computed(() => props.labelIconType === '')

//NOTE: FormStepContainerでerror-message-とwarning-message-のidを生成
const randomId = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)
</script>

<template>
  <div class="flex flex-col gap-0.5">
    <div class="flex flex-col items-start justify-start gap-0.5 md:flex-row md:items-center md:justify-between">
      <div class="flex gap-2">
        <IconTypeMapper v-if="!hasLabelIconType" :type="labelIconType" class="text-xl" />
        <label for="input" class="label-text text-nowrap font-bold">{{ label }}
          <span v-if="isRequired" class="text-error">*</span>
        </label>
      </div>
      <small v-if="help !== null" id="input-help" class="label-text-alt">{{ help }}</small>
    </div>
    <slot name="top"></slot>
    <div class="flex flex-row">
      <slot name="left"></slot>
      <slot></slot>
      <slot name="right"></slot>
    </div>
    <slot name="bottom"></slot>
    <div v-if="error || warning">
      <p :id="'error-message-' + randomId" class="text-sm text-error">
        {{ error }}
      </p>
      <p :id="'warning-message-' + randomId" class="text-sm text-warning">
        {{ warning }}
      </p>
    </div>
  </div>
</template>

<style lang="">
</style>
