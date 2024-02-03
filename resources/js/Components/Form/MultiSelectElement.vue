<script setup>
import { vOnClickOutside } from '@vueuse/components'
import draggable from 'vuedraggable'

const props = defineProps({
  //Wrapper用
  label: {
    type: String,
    required: true
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
  //このコンポーネント用
  modelValue: {
    type: Array,
    default: ()=>[],
  },
  selectableItems: {
    type: Array,
    default: ()=>[],
  },
  route: {
    type: String,
    default: ''
  },
  searchDelay: {
    type: Number,
    default: 200
  },
  itemType: {
    type: String,
    default: ''
  },
  labelIconType: {
    type: String,
    default: ''
  },
})

const emits = defineEmits(['update:modelValue'])

const inputRef = ref(null)
const inputText = ref('')
const items = ref([...props.modelValue])

const isOpen = ref(false)
const isExists = computed(() => filteredItems.value && filteredItems.value.length !== 0)
const isSearching =ref(false)
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
  return items.value.some(item => item === searchString)
}

const handleAdd = (tagName) => {
  console.log(tagName)
  isOpen.value=false
  if (tagName === ''){ return }
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
  isOpen.value=true
  isSearching.value = true
  filteredItems.value = ['', '', '']
  clearTimeout(searchTimeoutId)
  searchTimeoutId = setTimeout(() => {
    getFilteredItems(newValue)
    isSearching.value = false
  }, props.searchDelay)
})

const getFilteredItems = (searchValue) => {
  try {
    filteredItems.value = props.selectableItems.filter(item => item.includes(searchValue))
  } catch (error) {
    console.error('Error:', error)
  }
}

const onFocus=()=>{
  isOpen.value=true
  filteredItems.value= [...props.selectableItems]
}
const onClickOutsideHandler= ()=>{
  isOpen.value=false
  filteredItems.value= []
}

</script>

<template>
  <Wrapper
    v-on-click-outside="onClickOutsideHandler" :label="label" :help="help"
    :error="error" :label-icon-type="labelIconType">
    <div class="w-full">
      <!-- タグ入力ボックス -->
      <div class="input input-sm flex h-full w-full flex-wrap items-center gap-2 py-0.5">
        <!-- タグ表示 -->
        <draggable
          v-model="items"
          group="items"
          item-key="id"
          class="flex  flex-wrap gap-2"
          @start="dragging=true"
          @end="dragging=false">
          <template #item="{element}">
            <BtnConditionTypeMapper
              :type="itemType"
              @click="clickTagDelete(element)">
              <div class="relative">
                <IconTypeMapper
                  :type="itemType"
                  class="absolute left-0 top-0.5 text-lg opacity-100 transition-all duration-300 group-hover:opacity-0 " />
                <Icon
                  icon="mdi:close"
                  class="absolute left-0 top-0.5 -rotate-90 text-lg opacity-0 transition-all duration-300 group-hover:rotate-0 group-hover:opacity-100" />
                <div class="pl-6">
                  {{ element }}
                </div>
              </div>
            </BtnConditionTypeMapper>
          </template>
        </draggable>
        <div class="relative grow">
          <input
            ref="inputRef"
            v-model="inputText" class="input input-sm m-0 w-full shrink border-none p-0" :placeholder="placeholder"
            @keydown.enter="handleAdd(inputText)"
            @focus="onFocus">
          <!-- 検索結果をbutton表示 -->
          <div :class="[isOpen ? 'block' : 'hidden']" class="absolute left-0 z-40 mt-4 flex max-h-64 min-w-48 flex-col gap-0.5 overflow-y-auto rounded-md  bg-base-300 p-2 shadow-lg">
            <template v-for="(item, index) in filteredItems" :key="index">
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
