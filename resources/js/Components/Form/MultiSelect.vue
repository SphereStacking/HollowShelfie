<script setup>
import { ref, watch, computed } from 'vue'

const props = defineProps({
  tags: {
    type: Array,
    default: ()=>[],
  },
  placeholder: {
    type: String,
    default: '',
  },
  deleteBtn: Boolean,
  inputBox: Boolean,
})

const emits = defineEmits(['clickTag', 'update:tags'])

const newTag = ref('')
const items = ref([...props.tags])
const delimiter = ' '

const isOpen = computed(() => newTag.value !== '')
const isDeleteBtn = computed(() => props.deleteBtn === true)
const ifInputBox = computed(() => props.inputBox === true)

watch(() => props.tags, (val) => {
  if (items.value !== val) {
    items.value = val
  }
}, { deep: true, immediate: true })

const clickTag = (tagValue) => {
  emits('clickTag', tagValue)
}

const clickTagDelete = (tagValue) => {
  items.value = items.value.filter(item => ! [tagValue].includes(item))
  emits('update:tags', items.value)
}

const clickTagAdd = () => {
  addTag(newTag.value)
  clearInputTag()
}

const onKeyDown = () => {
  addTag(newTag.value)
  clearInputTag()
}

const addTag = (tagName) => {
  if (isIncludesString(tagName)) {
    alert('既にタグ(' + tagName + ')が存在します。')
    return
  }
  items.value.push(tagName)
}

const clearInputTag = () => {
  newTag.value = ''
}

const isIncludesString = (searchString) => {
  let searchTargetSting = [...items.value].map((value) => value).join(delimiter)+delimiter
  return searchTargetSting.includes(searchString+delimiter)
}
</script>

<template>
  <div>
    <!-- タグ入力ボックス -->
    <div v-if="ifInputBox" class="relative">
      <InputFormBase
        v-model="newTag" class="mt-1 block w-full" :placeholder="placeholder"
        @keydown.enter="onKeyDown" />
      <div :class="[isOpen ? 'block' : 'hidden']">
        <div class="absolute left-0 z-40 mt-2 w-full">
          <div class="rounded border border-gray-300 bg-white py-1 text-sm shadow-lg">
            <a class="block cursor-pointer px-5 py-1 hover:bg-indigo-600 hover:text-white" @click="clickTagAdd()"> Add tag "{{ newTag }}" </a>
          </div>
        </div>
      </div>
    </div>
    <!-- タグ表示 -->
    <div v-for="(item, index) in items" :key="index" class="mr-1 mt-2 inline-flex items-center overflow-hidden rounded  text-sm  hover:cursor-pointer ">
      <button v-if="isDeleteBtn" class="inline-block h-6 w-6  align-middle  focus:outline-none" @click="clickTagDelete(item)">
        <i class="fas fa-times"></i>
        <icon ic />
      </button>
      <BtnEventSerchItem />
      <span class="mx-1.5 my-0.5 max-w-xs truncate" @click="clickTag(item)">{{ item }}</span>
    </div>
  </div>
</template>
