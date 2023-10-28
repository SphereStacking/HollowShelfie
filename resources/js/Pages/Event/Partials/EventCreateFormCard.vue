
<script setup>
import { ref, reactive, nextTick } from 'vue'
import { useForm} from '@inertiajs/vue3'
import BtnSuccess from '@/Components/BtnSuccess.vue'

defineProps({ errors: Object })
const serchPerformer = ref()
const form = useForm({
  title: '',
  description: '',
  flyer: null,
  performers: [
    { No: '', name: '演者を追加してね!', categories: '' },
  ],
  date: '',
  dates: []
})

const createEvent = () => {
  form.post(route('event.store'), {
    preserveScroll: true,
    onSuccess: () => {},
    onError: () => {},
    onFinish: () => form.reset(),
  })
}
const addPerformer = (performer) => {
  form.performers.push({'name': performer, 'categories': ['ほげ', 'ふが']})
  console.log(form.performers)
  serchPerformer.value=''
}
const delPerformer = (index) => {
  form.performers.splice(index, 1)
}
const columDefs= [
  { headerName: 'No', field: 'No' },
  { headerName: '名前', field: 'name' },
  { headerName: 'カテゴリ', field: 'categories' },
  { headerName: '操作', field: 'ope' },
]

</script>

<template>
  <CardForm>
    <template #title>
      イベント作成！
    </template>
    <template #content>
      <InputTextLabel
        v-model="form.title"
        label="タイトル"
        :error="form.errors.title"
        help="イベントのタイトルを設定してください" />
      <InputTextareaLabel
        v-model="form.description"
        label="こんなイベントを開催する！"
        :error="form.errors.description"
        help="イベントの概要などを詳しく記入してください" />
      <InputTextLabel
        v-model="form.location_label"
        label="ラベルの"
        :error="form.errors.title"
        help="リンクを" />
      <InputTextLabel
        v-model="form.location_link"
        label="URL"
        :error="form.errors.title"
        help="開催場所のURLを記載してください！" />

      <InputTextLabel
        v-model="form.date"
        label="開催日"
        type="date"
        :error="form.errors.date"
        help="イベントの開催日を設定してください" />
      <InputTextLabel v-model="serchPerformer" label="演者を探す！" help="イベントの出演者を選択してください">
        <template #right>
          <BtnSecondary
            id="addPerformer"
            @click="addPerformer(serchPerformer)">
            よろしく頼む ＞人＜
          </BtnSecondary>
        </template>
      </InputTextLabel>
      <DataTable :colum-defs="columDefs" :row-data="form.performers" />
    </template>
    <template #actions>
      <BtnInfo @click="createEvent">
        下書き
      </BtnInfo>
      <BtnSuccess @click="createEvent">
        作成！
      </BtnSuccess>
    </template>
  </CardForm>
</template>
