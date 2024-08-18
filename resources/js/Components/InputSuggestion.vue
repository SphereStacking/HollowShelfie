<script setup>
import axios from 'axios'

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
  url: {
    type: [String, Function],
    default: '#'
  },
  searchDelay: {
    type: Number,
    default: 500
  },
  placeholder: {
    type: String,
    default: ''
  },
  getSuggestions: {
    type: Function,
    default: (res) => {
      return res
    }
  }
})

const emit = defineEmits(['suggestions', 'update:modelValue'])

const inputText = ref(props.modelValue? props.modelValue : '')
let searchTimeoutId = null

const responseLength = ref(0)

watch(() => props.modelValue, (val) => {
  inputText.value = val
}, { deep: true, immediate: true })

const searching = ref(false)
watch(inputText, (newValue) => {
  emit('update:modelValue', newValue)
  if (newValue === ''){
    suggestions.value = []
    return
  }
  searching.value = true
  clearTimeout(searchTimeoutId)
  searchTimeoutId = setTimeout(() => {
    fetchFilteredItems(newValue)
    searching.value = false
  }, props.searchDelay)
})

const suggestions = ref([])
watch(suggestions, (newValue) => {
  emit('suggestions', newValue)
})

const fetchFilteredItems = async (searchValue) => {
  const response = await axios({method: 'get', url: props.url, params: {q: searchValue} })
  if (response.status >= 200 && response.status < 300) {
    suggestions.value = props.getSuggestions(response)
    responseLength.value = suggestions.value.length
  }
}

const isNoExits = computed(() => {
  return responseLength.value === 0 && inputText.value !== '' && !searching.value
})
const isExits = computed(() => {
  return responseLength.value > 0 && inputText.value !== '' && !searching.value
})
</script>

<template>
  <label class="input input-sm input-bordered flex w-full items-center gap-2">
    <input
      v-model="inputText" type="text" class="input input-sm m-0 grow border-none p-0"
      :placeholder="placeholder">
    <div v-if="searching">
      <slot name="searching" v-bind="{ inputText}">
        <div class="badge badge-info w-full">
          検索中...
        </div>
      </slot>
    </div>
    <div v-else-if="isNoExits">
      <slot name="noExits" v-bind="{ inputText }">
        <div class="badge badge-error w-full">
          「{{ inputText }}」が存在しません
        </div>
      </slot>
    </div>
    <div v-else-if="isExits">
      <slot name="exits" v-bind="{ inputText, responseLength}">
        <div class="badge badge-success w-full">
          {{ responseLength }}件
        </div>
      </slot>
    </div>
  </label>
</template>

<style lang="">
</style>
