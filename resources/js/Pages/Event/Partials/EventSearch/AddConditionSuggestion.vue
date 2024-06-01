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
    return suggestions.value.map(v => v.screen_name)
  } else {
    return items.value
  }
})

</script>

<template>
  <div class="flex flex-wrap gap-2">
    <div class="join w-full  ">
      <InputSuggestion
        v-model="searchText"
        :placeholder="placeholder"
        :get-suggestions="(res) => {return res.data.suggestions.data}"
        :route="route" @suggestions="suggestions = $event" />
    </div>
    <div class="divider divider-start my-0 w-full">
      <div class="flex flex-row items-center  gap-1">
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
          <BtnEventSearchItem
            v-for="item in computedItems" :key="item" :type="type"
            :value="item"
            @click="addConditionFunc({ type: type, value: item })" />
        </slot>
      </transition-group>
    </div>
    <slot></slot>
  </div>
</template>
<style lang="">

</style>
