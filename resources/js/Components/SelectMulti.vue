<script setup>
import { ref } from 'vue'

// propsの定義
const props = defineProps({
  options: {
    type: Array,
    required: true,
  },
})

// 選択されたタグを格納するリアクティブな配列
const selectedTags = ref([])

// タグを選択する関数
const selectTag = (tag) => {
  if (!selectedTags.value.includes(tag)) {
    selectedTags.value.push(tag)
  }
}

// タグを削除する関数
const removeTag = (tag) => {
  const index = selectedTags.value.indexOf(tag)
  if (index !== -1) {
    selectedTags.value.splice(index, 1)
  }
}
</script>
<template>
  <div class="mx-auto flex h-64 w-full flex-col items-center md:w-1/2">
    <div class="w-full px-4">
      <div class="relative flex flex-col items-center">
        <div class="w-full">
          <div class="my-2 flex rounded border border-gray-200 bg-white p-1">
            <!-- タグ表示部分 -->
            <div
              v-for="tag in selectedTags" :key="tag"
              class="m-1 flex items-center justify-center rounded-full border border-teal-300 bg-teal-100 bg-white px-2 py-1 font-medium text-teal-700">
              <div class="max-w-full flex-initial text-xs font-normal leading-none">
                {{ tag }}
              </div>
              <div class="flex flex-auto flex-row-reverse">
                <!-- 削除ボタン -->
                <button @click="removeTag(tag)">
                  <svg
                    xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"
                    class="feather feather-x ml-2 h-4 w-4 cursor-pointer rounded-full hover:text-teal-400">
                    <line
                      x1="18" y1="6" x2="6"
                      y2="18" />
                    <line
                      x1="6" y1="6" x2="18"
                      y2="18" />
                  </svg>
                </button>
              </div>
            </div>
            <!-- 入力フィールド -->
            <div class="flex-1">
              <input
                placeholder=""
                class="h-full w-full appearance-none bg-transparent p-1 px-2 text-gray-800 outline-none">
            </div>
          </div>
        </div>
        <!-- オプションリスト -->
        <div class="top-100 lef-0 max-h-select absolute z-40 w-full overflow-y-auto rounded bg-white shadow">
          <div class="flex w-full flex-col">
            <div
              v-for="option in options" :key="option"
              class="w-full cursor-pointer border-b border-gray-100 hover:bg-teal-100" @click="selectTag(option)">
              <div class="relative flex w-full items-center border-l-2 border-transparent p-2 hover:border-teal-100">
                <div class="flex w-full items-center">
                  <div class="mx-2 leading-6">
                    {{ option }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
