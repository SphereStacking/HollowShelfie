<script setup>
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

// propsとemitsを定義
const props = defineProps({
  date: {
    type: Date,
    required: true
  },
})
const emit = defineEmits()

// 初期値として受け取ったdateをセット
const date = ref(props.initialDate)

// dateが変更されたらemitする
const updateDate = (newDate) => {
  date.value = newDate
  emit('update:date', newDate)
}

// ブラウザのロケールを取得
const locale = ref(navigator.language.slice(0, 2))
</script>

<template>
  <VueDatePicker
    time-picker :locale="locale" :model-value="date"
    hide-offset-dates range auto-apply
    @update:model-value="updateDate" />
</template>
