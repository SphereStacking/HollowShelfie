<script setup>

const props = defineProps({
  params: {
    type: Object,
    default: ()=> {}
  },
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

const emits = defineEmits(['update:modelValue'])

const performers= ref(props.modelValue?props.modelValue:[])
const getFilteredDataFunc = props.templateOptions['getFilteredDataFunc'] ?? ((item) => item)
const addFormatDataFunc = props.templateOptions['addFormatDataFunc'] ?? ((item) => item)
const route = props.templateOptions['route']

watch(performers, (value) => {
  emits('update:modelValue', value)
}, { deep: true})

</script>

<template>
  <MultiSearchable
    v-model="performers"
    class="input input-bordered h-full"
    item-type="performer"
    :route="route"
    label-key="name"
    :get-filtered-data-func="getFilteredDataFunc">
    <template #viewItem="{ element, handleDelete }">
      <PerformerBadge :performer="element" @click="handleDelete(element)" />
    </template>
    <template #searchItem="{ item, handleAdd}">
      <PerformerBadge :performer="item" @click="handleAdd(addFormatDataFunc(item))" />
    </template>
    <template #notExist>
      <button class="btn btn-md w-full gap-2 py-1 text-sm" disabled>
        見つかりません
      </button>
    </template>
  </MultiSearchable>
</template>

<style lang="">
</style>
