
<script setup>

import NumberElement from '@/Components/Form/NumberElement.vue'
import FormSteps from '@/Components/Form/Partials/FormSteps.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  title: '',
  description: '',
  location_label: '',
  location_link: '',
  date: '',
  performers: [],
  serchPerformer: '',
  columDefs: [
    { field: 'name', headerName: '名前', width: 200 },
    { field: 'description', headerName: '説明', width: 200 },
    { field: 'url', headerName: 'URL', width: 200 },
  ],
})

</script>

<template>
  {{ form }}

  <input class="input">
  <FormCard>
    <template #title>
      イベント作成！
    </template>

    <TextElement
      id="title" v-model="form.title" label="タイトル"
      :error="form.errors.title"
      help="イベントのタイトルを設定してください" />

    <TextElement
      v-model="form.location_label" label="カテゴリ" :error="form.errors.title"
      help="" />

    <MultiSelectElement
      v-model="form.location_label" label="タグ" :error="form.errors.tags"
      help=""
      input-box delete-btn />

    <EditorElement
      v-model="form.description"
      label="こんなイベントを開催する！" :error="form.errors.description"
      help="イベントの概要などを詳しく記入してください" />

    <DateTimeElement
      label="日時"
      help="" />
    <template #actions>
    </template>
  </FormCard>
</template>
