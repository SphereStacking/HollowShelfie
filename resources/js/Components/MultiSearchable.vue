<script setup>
import axios from 'axios'
import draggable from 'vuedraggable'

const props = defineProps({
  modelValue: {
    type: Array,
    default: ()=>[],
  },
  route: {
    type: String,
    default: ''
  },
  searchDelay: {
    type: Number,
    default: 500
  },
  itemType: {
    type: String,
    default: ''
  },
  labelIconType: {
    type: String,
    default: ''
  },
  placeholder: {
    type: String,
    default: ''
  },
  labelKey: {
    type: String,
    default: ''
  },
  enableEnterToAdd: {
    type: Boolean,
    default: false
  },
  //routeからのレスポンスを加工して配列を返す処理の受け渡し。
  getFilteredDataFunc: {
    type: Function,
    required: true,
    default: (data) =>{ return data }
  }
})

const emits = defineEmits(['update:modelValue'])

const inputRef = ref(null)
const inputText = ref('')
const items = ref(props.modelValue? [props.modelValue] : [])
const isOpen = computed(() => inputText.value !== '')
const isExists = computed(() => filteredItems.value && filteredItems.value.length !== 0)
const isSearching =ref(false)
const response = ref([])
const filteredItems = ref([])
const dragging= ref(false)
let searchTimeoutId = null

watch(() => props.modelValue, (val) => {
  if (items.value !== val) {
    items.value = val
  }
}, { deep: true, immediate: true })

const clickTagDelete = (tagValue) => {
  items.value = items.value.filter(item => ! [tagValue].includes(item))
  emits('update:modelValue', items.value)
}

const isIncludesString = (searchString) => {
  console.log(items.value)
  return items.value.some(item => item === searchString)
}
const handleEnterAdd = (inputText) => {
  if (props.enableEnterToAdd) {
    handleAdd(inputText)
  }
}

const handleAdd = (value) => {
  if (inputText.value === ''){ return }
  clearInputTag()
  inputRef.value.focus()
  inputRef.value.select()
  if (isIncludesString(value)) {
    alert('既に「' + value + '」が存在します。')
    return
  }
  items.value.push(value)
  emits('update:modelValue', items.value)
}

const clearInputTag = () => { inputText.value = ''}

watch(inputText, (newValue) => {
  if (newValue === ''){
    response.value=[]
    return
  }
  isSearching.value = true
  filteredItems.value = [{}, {}, {}]
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
      filteredItems.value = props.getFilteredDataFunc(response)
      console.log(filteredItems.value)
    }
  } catch (error) {
    console.error('Error:', error)
  }
}

const getLabel = (item) => {
  if (props.labelKey && typeof item === 'object') {
    return item[props.labelKey]
  }
  return item
}
</script>

<template>
  <!-- タグ入力ボックス -->
  <div class="input input-sm  flex size-full flex-wrap items-center gap-2 text-base-content">
    <!-- タグ表示 -->
    <draggable
      v-model="items"
      group="items"
      item-key="id"
      class="flex  flex-wrap gap-2 py-2"
      @start="dragging=true"
      @end="dragging=false">
      <template #item="{element}">
        <slot name="viewItem" :element="element" :handle-delete="clickTagDelete">
          <BtnConditionTypeMapper
            :type="itemType"
            @click="clickTagDelete(element)">
            <div class="relative">
              <IconTypeMapper
                :type="itemType"
                class="absolute left-0 top-0.5 text-lg opacity-100 transition-all duration-300 group-hover:opacity-0 " />
              <IconTypeMapper
                type="close"
                class="absolute left-0 top-0.5 -rotate-90 text-lg opacity-0 transition-all duration-300 group-hover:rotate-0 group-hover:opacity-100" />
              <div class="pl-6">
                {{ getLabel(element) }}
              </div>
            </div>
          </BtnConditionTypeMapper>
        </slot>
      </template>
    </draggable>

    <!-- 検索結果表示 -->
    <div class="relative grow">
      <input
        ref="inputRef"
        v-model="inputText" class="input input-sm m-0 w-full border-none p-0" :placeholder="placeholder"
        @keydown.enter="handleEnterAdd(inputText)">
      <!-- 検索結果をbutton表示 -->
      <div :class="[isOpen ? 'block' : 'hidden']" class="absolute left-0 z-40 mt-4 flex max-h-64 min-w-48 flex-col gap-0.5 overflow-y-auto rounded-md  bg-base-300 p-2 shadow-lg">
        <template v-for="(item, index) in filteredItems" :key="index">
          <slot
            name="searchItem" :item="item" :handle-add="handleAdd"
            :is-searching="isSearching">
            <div
              class="btn btn-sm flex w-full justify-between px-5 py-1  text-sm "
              @click="handleAdd(item)">
              <div> {{ getLabel(item) }}</div>
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
</template>

<style lang="">
</style>
