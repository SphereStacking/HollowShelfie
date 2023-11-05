<script setup>
import { ref } from 'vue';

// propsの定義
const props = defineProps({
  options: {
    type: Array,
    required: true,
  },
});

// 選択されたタグを格納するリアクティブな配列
const selectedTags = ref([]);

// タグを選択する関数
const selectTag = (tag) => {
  if (!selectedTags.value.includes(tag)) {
    selectedTags.value.push(tag);
  }
};

// タグを削除する関数
const removeTag = (tag) => {
  const index = selectedTags.value.indexOf(tag);
  if (index !== -1) {
    selectedTags.value.splice(index, 1);
  }
};
</script>
<template>
  <div class="w-full md:w-1/2 flex flex-col items-center h-64 mx-auto">
    <div class="w-full px-4">
      <div class="flex flex-col items-center relative">
        <div class="w-full">
          <div class="my-2 p-1 flex border border-gray-200 bg-white rounded">
            <!-- タグ表示部分 -->
            <div v-for="tag in selectedTags" :key="tag"
              class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-teal-700 bg-teal-100 border border-teal-300">
              <div class="text-xs font-normal leading-none max-w-full flex-initial">
                {{ tag }}
              </div>
              <div class="flex flex-auto flex-row-reverse">
                <!-- 削除ボタン -->
                <button @click="removeTag(tag)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-x cursor-pointer hover:text-teal-400 rounded-full w-4 h-4 ml-2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                </button>
              </div>
            </div>
            <!-- 入力フィールド -->
            <div class="flex-1">
              <input placeholder=""
                class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800">
            </div>
          </div>
        </div>
        <!-- オプションリスト -->
        <div class="absolute shadow top-100 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto">
          <div class="flex flex-col w-full">
            <div v-for="option in options" :key="option"
              class="cursor-pointer w-full border-gray-100 border-b hover:bg-teal-100" @click="selectTag(option)">
              <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                <div class="w-full items-center flex">
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
