
<script setup>

import {useForm, usePage} from '@inertiajs/vue3'
import { addMinutes } from 'date-fns'
import { parseToBrowserTz } from '@/Utils/Date'
import SearchPerformersGridElement from '@/Components/Grid/SearchPerformersGridElement.vue'
import RowDeleteGridElement from '@/Components/Grid/RowDeleteGridElement.vue'
import RowDragIndicatorGridElement from '@/Components/Grid/RowDragIndicatorGridElement.vue'
import PickerDateElement from '@/Components/Form/PickerDateElement.vue'

const categoryNames = usePage().props.categories.map(category => category.name)
const instanceTypeNames = usePage().props.instanceTypes

const event = usePage().props.event
const editorElement = ref(null)
const form = useForm({
  _method: 'PUT',
  title: '',
  categories: [],
  instances: [{
    instance_type_id: '',
    instance_type: '',
    access_url: '',
    display_name: '',
  }],
  tags: [],
  description: '',
  dates: [],
  organizers: [],
  time_tables: [],
  images: [],
  status: '',
  published_at: null,
  start_date: null,
  end_date: null,
})

const getFilteredDataFunc =(response) => {
  return response.data.suggestions.data
}
const addFormatData = (item) => {
  return { id: item.id, type: item.type, name: item.name, image_url: item.image_url, screen_name: item.screen_name}
}
import { generateUniqueId } from '@/Utils'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
const draggableGroupId = generateUniqueId('grid')
const columDefs = [
  { template: RowDragIndicatorGridElement, headerTitle: '', headerSubTitle: '', width: '30px'},
  { template: RowDeleteGridElement, headerTitle: '', headerSubTitle: '', width: '30px' },
  { field: 'duration', headerTitle: '出演時間', headerSubTitle: '(分)', width: '100px', template: 'input',
    getNewRowValue: () => { return 60 },
    templateOptions: {
      type: 'number',
    }
  },
  { field: 'description', headerTitle: '内容', headerSubTitle: '演目/項目/未登録ユーザ', width: 'auto', minWidth: '300px', template: 'input' },
  { field: 'performers', headerTitle: '演者/応対者/スタッフ', headerSubTitle: '未登録ユーザーは内容に記載してください', width: '202px', template: SearchPerformersGridElement,
    templateOptions: {
      route: route('mention.suggestion'),
      getFilteredDataFunc: getFilteredDataFunc,
      addFormatDataFunc: addFormatData,
    },
    options: {
      group: draggableGroupId,
      placeholder: 'ユーザーID,ユーザー名'
    }
  },
]

const emit = defineEmits(['success', 'error'])

const formCard = ref(null)

const formSubmit = (isPublish)=>{
  form.published_at = isPublish ? new Date() : null
  let currentTime = new Date(form.start_date)
  form.time_tables = form.time_tables.map(timeTable => {
    const duration = timeTable.duration
    const startDate = new Date(currentTime)
    currentTime = addMinutes(currentTime, duration)
    const endDate = new Date(currentTime)
    return {
      ...timeTable,
      start_date: startDate,
      end_date: endDate
    }
  })

  form.put(route('event.update', event.alias), {
    preserveScroll: true,
    onSuccess: () => {
      emit('success', usePage().props.response.event)
    },
    onError: () => {
      emit('error')
      formCard.value.scrollToTop()
    },
  })
}

//NOTE:要望が多ければユーザーごとにテンプレートを用意する機能を追加する。
const descriptionTemplates = ref({
  default: {
    name: 'default',
    content: `
      <h3>内容</h3>
      <p></p>
      <h3>参加条件</h3>
      <ul>
        <li><p></p></li>
        <li><p></p></li>
      </ul>
      <h3>注意事項</h3>
      <ul>
        <li><p></p></li>
        <li><p></p></li>
      </ul>
      <p></p>
    `
  },
})

onBeforeMount(() => {

  form.title = event.title
  form.categories = event.category_names
  if (event.instances && event.instances.length > 0) {
    form.instances[0].instance_type_id = event.instances[0].instance_type_id
    form.instances[0].instance_type = event.instances[0].instance_type
    form.instances[0].access_url = event.instances[0].access_url
    form.instances[0].display_name = event.instances[0].display_name
  }
  form.tags = event.tags
  form.description = event.description
  form.start_date = event.start_date ? parseToBrowserTz(event.start_date) : new Date(),
  form.end_date = event.end_date ? parseToBrowserTz(event.end_date) : new Date(),
  form.organizers = event.organizers
  form.time_tables = event.time_table
  form.images = event.files
})

watch(() => form.time_tables, () => {
  updateEndDate()
}, { deep: true })

watch(() => form.start_date, () => {
  updateEndDate()
}, { deep: true })

const updateEndDate = () => {
  if (form.time_tables.length > 0) {
    const startTime = new Date(form.start_date)
    const totalMinutes = form.time_tables.reduce((total, item) => total + item.duration, 0)
    form.end_date = addMinutes(startTime, totalMinutes)
  } else {
    form.end_date = new Date(form.start_date)
  }
}

</script>

<template>
  <FormCard ref="formCard">
    <template #title>
      <div class="flex w-full items-center justify-between">
        <div>
          イベント作成！
        </div>
        <div>
          <a class="btn btn-neutral btn-sm" :href="route('event.manage')">
            管理画面に戻る
            <IconTypeMapper type="arrowRight" class="shrink-0 text-xl" />
          </a>
        </div>
      </div>
    </template>

    <div class="grid grid-cols-1 gap-2 sm:grid-cols-4">
      <SelectElement
        v-model="form.instances[0].instance_type_id"
        label="プラットフォーム"
        label-icon-type="instance"
        class="w-full"
        id-key="id"
        label-key="name"
        :error="form.errors['instances.0.instance_type_id']"
        is-required
        :selectable-items="instanceTypeNames" />
      <TextElement
        v-model="form.title"
        class="col-span-3"
        label="タイトル"
        label-icon-type="title"
        help=""
        is-required
        :error="form.errors.title" />
    </div>

    <Wrapper
      label="アクセス"
      is-required
      help="urlを入力するとlabelが'link'形式になります。"
      :error="form.errors['instances.0.display_name']"
      label-icon-type="directions">
      <div class="grid w-full grid-cols-1 gap-2 sm:grid-cols-5">
        <input
          v-model="form.instances[0].display_name"
          :class="{ 'input-error': form.errors['instances.0.display_name'] }"
          class="input input-sm col-span-2"
          placeholder="label (例 グループにJoin)">
        <input
          v-model="form.instances[0].access_url"
          class="input input-sm  col-span-3"
          placeholder="url (例 https://...)">
      </div>
    </Wrapper>

    <MultiSelectElement
      v-model="form.categories"
      label="カテゴリ"
      label-icon-type="category"
      item-type="category"
      is-required
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
      item-type="tag"
      help="複数選択可能です。数の多いタグを使用することで見つかりやすくなります。"
      :error="form.errors.tags"
      item-icon-type="tag"
      :route="route('tag.suggestion')"
      label-key="name"
      enable-enter-to-add
      :get-filtered-data-func="getFilteredDataFunc">
      <template #viewItem="{ element, handleDelete }">
      </template>
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
      label="主催者/関係者"
      label-icon-type="organizer"
      help="主催者を選択してください"
      placeholder="ユーザーID,ユーザー名"
      :error="form.errors.organizers"
      item-type="organizer"
      :route="route('mention.suggestion')"
      label-key="name"
      :get-filtered-data-func="getFilteredDataFunc">
      <template #viewItem="{ element, handleDelete }">
        <PerformerBadge :performer="element" @click="handleDelete(element)" />
      </template>
      <template #searchItem="{ item, handleAdd, isSearching }">
        <PerformerBadge :performer="item" :is-searching="isSearching" @click="!isSearching && handleAdd(addFormatData(item))" />
      </template>
      <template #notExist="{ inputText, handleAdd}">
        <button class="btn btn-md w-full gap-2 py-1 text-sm" disabled>
          見つかりません
        </button>
      </template>
    </MultiSearchableElement>

    <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
      <PickerDateElement
        v-model="form.start_date"
        :error="form.errors.start_date"
        label-icon-type="date"
        is-required
        label="開始日時" />
      <PickerDateElement
        v-model="form.end_date"
        :error="form.errors.end_date"
        label="終了日時"
        help="タイムテーブルを入力すると自動で計算されます。"
        is-required
        disabled />
    </div>

    <GridElement
      v-model="form.time_tables"
      label="タイムテーブル"
      label-icon-type="timeline"
      :error="form.errors.time_tables"
      help="未登録ユーザの演者へHollowShelfieを紹介してみてください！"
      :colum-defs="columDefs" />

    <div class="grid grid-cols-1 gap-2 md:grid-cols-4">
      <EditorElement
        ref="editorElement"
        v-model="form.description"
        label-icon-type="wysiwygEditor"
        label="詳細"
        class="col-span-3"
        :error="form.errors.description"
        is-required />
      <div class="col-span-1 h-full">
        <div class="sticky top-16 z-20 mt-5">
          <div class="flex flex-col gap-2 rounded-md border border-info bg-base-300 p-2">
            <div>
              <div class="flex flex-row items-center gap-0.5">
                <p class="flex flex-row items-center gap-1 text-sm">
                  <span class="text-sm">
                    <IconTypeMapper type="info" inline class="text-sm text-info" />
                  </span>
                  <span class="text-sm">
                    テンプレート
                  </span>
                </p>
                <button class="btn btn-neutral btn-xs tooltip " data-tip="テンプレートをクリア" @click="editorElement.setContent()">
                  <IconTypeMapper type="clear" class="text-sm text-base-content" />
                </button>
              </div>
              <div class="flex flex-wrap gap-2">
                <button
                  v-for="(template, key) in descriptionTemplates" :key="key" class="btn btn-neutral btn-xs"
                  @click="editorElement.setContent(template.content)">
                  {{ template.name }}
                </button>
              </div>
            </div>
          </div>
          <div class=" mt-2 flex flex-col gap-2 rounded-md border border-info bg-base-300 p-2">
            <div class="flex flex-row items-center gap-0.5">
              <IconTypeMapper type="hint" inline class="text-sm text-info" />
              <p class="text-sm">
                ヒント
              </p>
            </div>
            <ul class="list-inside list-disc text-xs leading-relaxed">
              <li>
                <p class="tooltip" data-tip="イベントの特徴やターゲットとなる参加者について記述すると、より魅力的に伝わります。">
                  詳細を記載しよう
                </p>
              </li>
              <li>
                <p class="tooltip" data-tip="参加者がどのような体験を期待できるかを具体的に書くと、わかりやすくなります。">
                  イベントの雰囲気を伝えよう
                </p>
              </li>
            </ul>
          </div>
          <div class=" mt-2 flex flex-col gap-2 rounded-md border border-info bg-base-300 p-2">
            <div class="flex flex-row items-center gap-0.5">
              <IconTypeMapper type="help" inline class="text-sm text-info" />
              <p class="text-sm">
                ヘルプ
              </p>
            </div>
            <ul class="list-inside list-disc text-xs leading-relaxed">
              <li>
                <strong class="text-info">リンク</strong><br>
                <p class="pr-2">
                  テキストを選択し、🔗をクリック。
                </p>
              </li>
              <li>
                <strong class="text-info">段落内で改行</strong><br>
                <p class="pr-2">
                  「shift」+「enter」
                </p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <FileInputElement
      v-model="event.files"
      label="フライヤー/ポスター"
      label-icon-type="fryer"
      :upload-route="route('event.fryer.store', event.alias)"
      :delete-route="route('event.fryer.destroy')"
      :error="form.errors.images"
      help="縦A4サイズ推奨"
      max-file-size="2MB" />
    <template #actions>
      <div class="mx-20 grid w-full grid-cols-2 gap-2">
        <button class="btn btn-outline " @click="formSubmit(false)">
          下書きで保存する
        </button>
        <button class="btn btn-primary " @click="formSubmit(true)">
          公開で保存する
        </button>
      </div>
    </template>
  </FormCard>
</template>
<style scoped>

</style>
