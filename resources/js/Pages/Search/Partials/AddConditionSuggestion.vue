<script setup>
const props = defineProps({
  items: {
    type: Array,
    required: true
  },
  type: {
    type: String,
    required: true
  },
  placeholder: {
    type: String,
    required: true
  },
  route: {
    type: String,
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

const items = ref(props.items ? props.items.map(v => v) : [])

const computedItems = computed(() => {
  if (suggestions.value.length > 0) {
    return suggestions.value.map(v => v.name)
  } else {
    return items.value
  }
})

</script>

<template>
  <div class="flex flex-wrap gap-2">
    <div class="join w-full">
      <InputSuggestion
        v-model="searchText"
        :placeholder="placeholder"
        :get-suggestions="(res) => {return res.data.suggestions.data}"
        :route="route" @suggestions="suggestions = $event" />
    </div>
    <transition-group
      tag="div" class="flex flex-wrap gap-2"
      leave-active-class="transition ease-in duration-75 absolute"
      leave-from-class="transform opacity-100"
      leave-to-class="transform opacity-0">
      <BtnEventSerchItem
        v-for="item in computedItems" :key="item" :type="type"
        :value="item"
        @click="addConditionFunc({ type: type, value: item })" />
    </transition-group>
  </div>
</template>
<style lang="">

</style>
