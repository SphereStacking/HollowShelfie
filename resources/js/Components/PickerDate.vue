<script setup>
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

// propsとemitsを定義
const { date: initialDate } = defineProps(['date'])
const emit = defineEmits()

// 初期値として受け取ったdateをセット
const date = ref(initialDate)

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
    :locale="locale" :model-value="date" auto-apply
    @update:model-value="updateDate" />
</template>
