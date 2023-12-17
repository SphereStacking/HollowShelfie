<script setup>
import { ref, watch } from 'vue'
const props = defineProps({
  label: {
    type: Number,
    required: true
  },
  modelValue: {
    type: String,
    default: 'hoge'
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
  type: {
    type: String,
    default: 'text'
  }
})

</script>

<template>
  <div class="flex flex-col gap-2">
    <label for="input" class="text-lg font-bold">{{ label }}</label>
    <div class="flex flex-row">
      <slot name="left">
      </slot>
      <input id="input" :type="type" :placeholder="placeholder" class="input input-bordered grow input-sm"
        :class="{ 'outline outline-offset-2 outline-pink-500': error }" :value="modelValue" aria-describedby="input-help"
        @input="$emit('update:modelValue', $event.target.value)">
      <slot name="right">
      </slot>
    </div>
    <small v-if="help !== null" id="input-help">{{ help }}</small>
    <InputError :message="error" />
  </div>
</template>

<style lang="">
</style>
