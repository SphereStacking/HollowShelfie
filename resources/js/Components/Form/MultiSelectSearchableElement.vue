<script setup>
import axios from 'axios'
const props = defineProps({
  //Wrapper用
  label: {
    type: String,
    required: true
  },
  items: {
    type: Array,
    default: ()=>[],
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
  route: {
    type: String,
    default: ''
  },
  searchDelay: {
    type: Number,
    default: 500
  },
  iconType: {
    type: String,
    default: 'tag'
  },
  //routeからのレスポンスを加工して配列を返す処理の受け渡し。
  getFilteredDataFunc: {
    type: Function,
    required: true,
    default: (data) =>{ return data }
  }
})

const emits = defineEmits(['clickTag', 'update:items'])

const inputRef = ref(null)
const inputText = ref('')
const items = ref([...props.items])

const isOpen = computed(() => inputText.value !== '')
const isExists = computed(() => FilteredItems.value && FilteredItems.value.length !== 0)
const isSearching =ref(false)
const response = ref([])
const FilteredItems = ref([])
let searchTimeoutId = null

watch(() => props.items, (val) => {
  if (items.value !== val) {
    items.value = val
  }
}, { deep: true, immediate: true })

const clickTagDelete = (tagValue) => {
  items.value = items.value.filter(item => ! [tagValue].includes(item))
  emits('update:items', items.value)
}

const isIncludesString = (searchString) => {
  return items.value.some(item => item === searchString)
}

const handleAdd = (tagName) => {
  if (inputText.value === ''){ return }
  clearInputTag()
  inputRef.value.focus()
  inputRef.value.select()
  if (isIncludesString(tagName)) {
    alert('既に「' + tagName + '」が存在します。')
    return
  }
  items.value.push(tagName)
}

const clearInputTag = () => { inputText.value = ''}

watch(inputText, (newValue) => {
  if (newValue === ''){
    response.value=[]
    return
  }
  isSearching.value = true
  FilteredItems.value = [{}, {}, {}]
  clearTimeout(searchTimeoutId)
  searchTimeoutId = setTimeout(() => {
    fetchFilteredItems(newValue)
    isSearching.value = false
  }, props.searchDelay)
})

const fetchFilteredItems = async (searchValue) => {
  const url = props.route
  const method = 'get'
  try {
    const response = await axios({method: method, url: url, params: {q: searchValue} })
    if (response.status >= 200 && response.status < 300) {
      FilteredItems.value = props.getFilteredDataFunc(response)
      console.log(FilteredItems.value)
    }
  } catch (error) {
    console.error('Error:', error)
  }
}

</script>

<template>
  <Wrapper :label="label" :help="help" :error="error">
    <div class="w-full">
      <!-- タグ入力ボックス -->
      <div class="input input-sm flex h-full w-full flex-wrap items-center gap-2 py-1.5">
        <!-- タグ表示 -->
        <BtnConditionTypeMapper
          v-for="(item, index) in items" :key="index" :type="iconType"
          @click="clickTagDelete(item)">
          <div class="relative">
            <IconTypeMapper
              type="tag"
              class="absolute left-0 top-0.5 text-lg opacity-100 transition-all duration-300 group-hover:opacity-0 " />
            <Icon
              icon="mdi:close"
              class="absolute left-0 top-0.5 -rotate-90 text-lg opacity-0 transition-all duration-300 group-hover:rotate-0 group-hover:opacity-100" />
            <div class="pl-6">
              {{ item }}
            </div>
          </div>
        </BtnConditionTypeMapper>
        <div class="relative grow">
          <input
            ref="inputRef"
            v-model="inputText" class="input input-sm m-0 w-full border-none p-0" :placeholder="placeholder"
            @keydown.enter="handleAdd(inputText)">
          <!-- 検索結果をbutton表示 -->
          <div :class="[isOpen ? 'block' : 'hidden']" class="absolute left-0 z-40 mt-4 flex max-h-64 min-w-48 flex-col gap-0.5 overflow-y-auto rounded-md  bg-base-300 p-2 shadow-lg">
            <template v-for="(item, index) in FilteredItems" :key="index">
              <slot
                name="searchItem" :item="item" :handle-add="handleAdd"
                :is-searching="isSearching">
                <div
                  class="btn btn-sm flex w-full justify-between px-5 py-1  text-sm "
                  @click="handleAdd(item)">
                  <div>{{ item }}</div>
                </div>
              </slot>
            </template>
            <div v-if="!isExists">
              <slot
                name="notExist" :handle-add="handleAdd" :input-text="inputText">
                <div
                  class="btn btn-sm flex w-full justify-between px-5 py-1  text-sm"
                  @click="handleAdd(inputText)">
                  Nothing {{ inputText }}
                </div>
              </slot>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Wrapper>
</template>

<style lang="">
</style>
