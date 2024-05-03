<script setup>
import axios from 'axios'

const props = defineProps({
  //このコンポーネント用
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
  //routeからのレスポンスを加工して配列を返す処理の受け渡し。
  templateOptions: {
    type: Object,
    default: ()=>{},
  }
})

const getFilteredDataFunc = props.templateOptions['getFilteredDataFunc']
const route = props.templateOptions['route']

</script>

<template>
  <MultiSearchable
    item-type="performer"
    :route="route"
    :get-filtered-data-func="getFilteredDataFunc">
    <template #searchItem="{ item, handleAdd}">
      <div class="btn btn-md flex w-full flex-row  items-center justify-start gap-2 py-1 text-sm" @click="handleAdd(item.name)">
        <div class="avatar">
          <div class="w-10 rounded-xl" :class="item.image_url ? '' : 'skeleton'">
            <img v-if="item.image_url" :src="item.image_url">
          </div>
        </div>
        <div class="flex flex-col justify-start text-left ">
          <div class="font-bold">
            {{ item.name }}
          </div>
          <div class="text-xs opacity-30">
            <template v-if="item.screen_name">
              @{{ item.screen_name }}
            </template>
          </div>
        </div>
      </div>
    </template>
    <template #notExist="{ inputText, handleAdd}">
      <button class="btn btn-md w-full gap-2 py-1 text-sm" disabled>
        見つかりません
      </button>
    </template>
  </MultiSearchable>
</template>

<style lang="">
</style>
