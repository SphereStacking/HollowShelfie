
<script setup>

import {useForm, usePage} from '@inertiajs/vue3'

import SearchPerformersGridElement from '@/Components/Grid/SearchPerformersGridElement.vue'
import PickerTimeGridElement from '@/Components/Grid/PickerTimeGridElement.vue'
import RowDeleteGridElement from '@/Components/Grid/RowDeleteGridElement.vue'

const categoryNames = usePage().props.categories.map(category => category.name)
const instanceTypeNames = usePage().props.instanceTypes.map(instanceType => instanceType.name)

const form = useForm({
  _method: 'PUT',
  title: '',
  categories: [],
  instance_type: '',
  instance_url: '',
  tags: [],
  description: '',
  dates: [],
  organizers: [],
  time_tables: [],
  images: [],
  status: '',
})

const getFilteredDataFunc =(response) => {
  return response.data.suggestions.data
}

const columDefs = [
  { template: RowDeleteGridElement, headerName: '-', width: '10px' },
  { field: 'times', headerName: '出演時間', width: '170px', template: PickerTimeGridElement},
  { field: 'performers', headerName: 'パフォーマー', width: '200px', template: SearchPerformersGridElement,
    templateOptions: {
      route: route('mention.suggestion'),
      getFilteredDataFunc: getFilteredDataFunc
    }
  },
  { field: 'description', headerName: '説明', width: '200px', template: 'textarea'},
]

const formSubmit = (status)=>{
  form.status=status
  form.post(route('event.store'), {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {},
    onError: () => {},
  })
}

</script>

<template>
  {{ form }}

  <FormCard>
    <template #title>
      イベント作成！
    </template>

    <TextElement
      v-model="form.title"
      label="タイトル"
      label-icon-type="title"
      help=""
      :error="form.errors.title" />

    <SelectElement
      v-model="form.instance_type"
      label="インスタンス"
      label-icon-type="instance"
      help="開催場所を選択"
      class=""
      :error="form.errors.instance_type"

      :selectable-items="instanceTypeNames">
      <template #joinRight>
        <input v-model="form.instance_url" class="input join-item input-sm w-full" placeholder="url">
      </template>
    </SelectElement>

    <PickerFullDayRangeElement
      v-model="form.dates"
      :error="form.errors.dates"
      label-icon-type="date"
      label="日時"
      help="" />

    <MultiSelectElement
      v-model="form.categories"
      label="カテゴリ"
      label-icon-type="category"
      help="メインとなるカテゴリをはじめに選択してください。"
      :error="form.errors.categories"
      :selectable-items="categoryNames">
      <template #notExist="{ inputText, handleAdd}">
        <button class="btn btn-disabled btn-sm flex w-full justify-between px-5 py-1 text-sm">
          Nothing {{ inputText }}
        </button>
      </template>
    </MultiSelectElement>

    <MultiSearchableElement
      v-model="form.tags"
      label="タグ"
      label-icon-type="tag"
      help="複数選択可能です。数の多いタグを使用することで見つかりやすくなります。"
      :error="form.errors.tags"
      item-icon-type="tag"
      :route="route('tag.suggestion')"
      label-key="name"
      :get-filtered-data-func="getFilteredDataFunc">
      <template #searchItem="{ item, handleAdd}">
        <div
          class="btn btn-sm flex w-full justify-between px-5 py-1  text-sm"
          @click="handleAdd(item.name)">
          <div> {{ item.name }}</div>
          <div class="badge badge-secondary badge-xs w-5">
            {{ item.taggables_count }}
          </div>
        </div>
      </template>
      <template #notExist="{ inputText, handleAdd}">
        <div
          class="btn btn-sm flex w-full justify-between px-5 py-1  text-sm"
          @click="handleAdd(inputText)">
          {{ inputText }}
          <div class="badge badge-primary badge-xs">
            new
          </div>
        </div>
      </template>
    </MultiSearchableElement>
    <MultiSearchableElement
      v-model="form.organizers"
      label="オーガナイザー"
      label-icon-type="organizer"
      help="主催者を選択してください"
      :error="form.errors.organizers"
      item-type="organizer"
      :route="route('mention.suggestion')"
      label-key="name"
      :get-filtered-data-func="getFilteredDataFunc">
      <template #searchItem="{ item, handleAdd}">
        <div
          class="btn btn-md flex w-full flex-row  items-center justify-start gap-2 py-1 text-sm"
          @click="handleAdd({ id: item.identifiable_id, type: item.identifiable_type, name: item.name })">
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
              <template v-if="item.alias_name">
                @{{ item.alias_name }}
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
    </MultiSearchableElement>

    <GridElement
      v-model="form.time_tables"
      label="タイムテーブル"
      label-icon-type="timeline"
      :error="form.errors.time_tables"
      help=""
      :colum-defs="columDefs" />

    <EditorElement
      v-model="form.description"
      label-icon-type="wysiwygEditor"
      label="こんなイベントを開催する！"
      :error="form.errors.description"
      help="イベントの概要などを詳しく記入してください" />

    <FileInputElement
      v-model="form.images"
      label="フライヤー"
      label-icon-type="fryer"
      :error="form.errors.images"
      help="先頭の画像がイベント表示の際の縦横比を決定します。画像サイズは統一することをお勧めします。"
      max-file-size="30MB"
      max-total-size="30MB" />

    <template #actions>
      <div class="mx-20 grid w-full grid-cols-2 gap-2">
        <button class="btn btn-outline " @click="formSubmit('draft')">
          下書きで保存する
        </button>
        <button class="btn btn-primary " @click="formSubmit('upcoming')">
          公開で保存する
        </button>
      </div>
    </template>
  </FormCard>
</template>
<style scoped>

</style>
