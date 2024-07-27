<script setup>
const props = defineProps({
  idKey: { // オブジェクトの配列の場合のidのキー
    type: String,
    default: null
  },
  labelKey: { // オブジェクトの配列の場合の表示名のキー
    type: String,
    default: null
  },
  label: { // ラベル
    type: String,
    required: true
  },
  labelIconType: { // ラベルのアイコンの種類
    type: String,
    default: ''
  },
  modelValue: { // v-modelの値
    type: [String, Number],
    default: ''
  },
  placeholder: { // プレースホルダー
    type: String,
    default: ''
  },
  help: { // ヘルプテキスト
    type: String,
    default: null
  },
  error: { // エラーメッセージ
    type: [String, Object],
    default: null
  },
  //TODO: 必要になったらObjectの処理を追加する
  warning: {
    type: String,
    default: null
  },
  selectableItems: { // 選択肢
    type: Array,
    default: ()=>[]
  },

})

const emit = defineEmits(['update:modelValue'])

const updateValue = (event) => {
  emit('update:modelValue', event.target.value)
}
const isObjectArray = computed(() => {
  return props.selectableItems.length > 0 && typeof props.selectableItems[0] === 'object'
})

// errorがオブジェクトの場合、selectErrorとwrapperErrorを分ける
// NOTE: このコンポーネントでは、selectErrorはselect要素に対するエラーメッセージ、
//       wrapperErrorはラッパー要素に対するエラーメセージとして扱う
const errorMessages = computed(() => {
  if (typeof props.error === 'object' && props.error !== null) {
    return props.error
  }
  return {
    selectError: props.error,
    wrapperError: props.error
  }
})

</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="errorMessages.wrapperError"
    :warning="warning"
    :label-icon-type="labelIconType">
    <div class="join grow">
      <slot name="joinLeft"></slot>
      <select
        v-bind="$attrs"
        class="join-item select select-sm rounded-md py-0.5" :value="modelValue"
        :class="{ 'select-error': errorMessages.selectError }" @change="updateValue($event)">
        <option disabled value="">
          {{ placeholder }}
        </option>
        <option v-for="item in selectableItems" :key="isObjectArray ? item[idKey] : item" :value="isObjectArray ? item[idKey] : item">
          {{ isObjectArray ? item[labelKey] : item }}
        </option>
      </select>
      <slot name="joinRight"></slot>
    </div>
  </Wrapper>
</template>

<style lang="">
</style>
