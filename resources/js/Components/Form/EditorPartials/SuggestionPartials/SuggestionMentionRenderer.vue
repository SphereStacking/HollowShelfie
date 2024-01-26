<script setup>
import axios from 'axios'

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
  command: {
    type: Function,
    required: true,
  },
})
const selectedIndex = ref(0)
const suggestionItems = ref([])
const isSearching = ref(false)
const searchTimeoutId = ref(null)

watch(() => props.items, async (newValue) => {
  if (newValue === '') {
    suggestionItems.value = []
    return
  }
  selectedIndex.value = 0
  isSearching.value = true
  suggestionItems.value = [{}, {}, {}] // UXの観点で 仮のデータを入れておく。
  clearTimeout(searchTimeoutId.value)
  searchTimeoutId.value = setTimeout(async () => {
    const fetchResponse = await fetchFilteredItems(newValue)
    suggestionItems.value = fetchResponse.data.suggestions.data
    isSearching.value = false
  }, 200)
})

const fetchFilteredItems = async (searchValue) => {
  const url = route('mention.suggestion')
  try {
    const response = await axios.get(url, { params: { q: searchValue } })
    if (response.status >= 200 && response.status < 300) {
      return response
    }
  } catch (error) {
    console.error('Error:', error)
    suggestionItems.value = []
  }
}

const onKeyDown = ({ event }) => {
  if (event.key === 'ArrowUp') {
    upHandler()
    return true
  }
  if (event.key === 'ArrowDown') {
    downHandler()
    return true
  }
  if (event.key === 'Enter') {
    enterHandler()
    return true
  }
  return false
}

const upHandler = () => {
  selectedIndex.value = (selectedIndex.value + props.items.length - 1) % props.items.length
}

const downHandler = () => {
  selectedIndex.value = (selectedIndex.value + 1) % props.items.length
}

const enterHandler = () => {
  selectItem(selectedIndex.value)
}

const selectItem = (index) => {
  const item = suggestionItems.value[index]
  if (item) {
    props.command({ id: item.alias_name })
  }
}
onMounted(() => {
  // 初期化処理があればここに書く
})

defineExpose({
  onKeyDown
})
</script>

<template>
  <div>
    <div v-if="suggestionItems.length > 0" class="flex max-h-64 min-w-48 flex-col gap-0.5 overflow-y-auto rounded-md bg-base-300 p-2 shadow-lg">
      <div
        v-for="(item, index) in suggestionItems"
        :key="index"
        class="btn btn-md flex w-full flex-row  items-center justify-start gap-2 py-1 text-sm"
        :class="Object.keys(item).length === 0 ? 'skeleton' : ''"
        @click="selectItem(index)">
        <div class="avatar">
          <div class="w-10 rounded-xl" :class="item.pohto_url ? '' : 'skeleton'">
            <img v-if="item.pohto_url" :src="item.pohto_url">
          </div>
        </div>
        <div class="flex flex-col justify-start text-left ">
          <div class="font-bold">
            {{ item.name }}
          </div>
          <div class="text-xs opacity-30">
            <template v-if="item.alias_name">
              @{{ item.alias_name }}
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
</style>
