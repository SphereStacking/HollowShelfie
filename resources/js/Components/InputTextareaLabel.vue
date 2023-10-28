<script setup>
defineProps({
  id: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: false
  },
  modelValue: {
    type: String,
    default: 'hoge'
  },
  help: {
    type: String,
    default: null
  }
})

</script>

<template>
  <div class="flex flex-col gap-2">
    <label
      v-if="label!==null" :id="id+'label'" for="input"
      class="text-lg font-bold">{{ label }}</label>
    <textarea
      :id="id"
      class="textarea textarea-bordered" placeholder="Bio"
      :value="modelValue" aria-describedby="input-help"
      @input="$emit('update:modelValue', $event.target.value)"></textarea>
    <small :id="id+'help'" v-if="help!==null">{{ help }}</small>
  </div>
</template>

<style lang="">
</style>
