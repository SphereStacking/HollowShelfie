<script setup>
defineProps({
  placeholder: {
    type: String,
    required: true
  },
  url: {
    type: [String, Function],
    required: true
  },
  addConditionFunc: {
    type: Function,
    required: true
  }
})

defineEmits(['addCondition'])
const suggestions = ref([])
const searchText = ref('')

</script>

<template>
  <div class="flex flex-wrap gap-2">
    <InputSuggestion
      v-model="searchText"
      :placeholder="placeholder"
      :get-suggestions="(res) => {return res.data.suggestions.data}"
      :url="url" @suggestions="suggestions = $event" />
    <div class="divider divider-start my-0 w-full">
      <div class="flex flex-row items-center gap-1">
        <IconTypeMapper type="search" class="text-xl" />
        Searched
      </div>
    </div>
    <div class="flex min-h-6 flex-wrap gap-2">
      <transition-group
        leave-active-class="transition ease-in "
        leave-from-class="transform opacity-100"
        leave-to-class="transform opacity-0">
        <slot name="items" :suggestions="suggestions">
        </slot>
      </transition-group>
    </div>
    <slot></slot>
  </div>
</template>
<style lang="">

</style>
