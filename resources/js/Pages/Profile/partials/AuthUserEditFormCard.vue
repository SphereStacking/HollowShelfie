
<script setup>

import {useForm, usePage, Link} from '@inertiajs/vue3'
import RowDeleteGridElement from '@/Components/Grid/RowDeleteGridElement.vue'
import RowDragIndicatorGridElement from '@/Components/Grid/RowDragIndicatorGridElement.vue'
import { parseErrors } from '@/Utils/LavaleValidate'

const profile = usePage().props.profile.detail
const form = useForm({
  _method: 'PUT',
  bio: '',
  links: [],
  tags: [],
})

const columDefs = [
  { template: RowDragIndicatorGridElement, headerTitle: '', width: '30px' },
  { template: RowDeleteGridElement, headerTitle: '', width: '30px' },
  { field: 'link', headerTitle: 'リンク', width: 'auto', minWidth: '200px', template: 'input', options: { placeholder: 'https://', required: true } },
  { field: 'label', headerTitle: 'ラベル', width: 'auto', minWidth: '200px', template: 'input', options: { placeholder: '表示', required: true } },
]
onBeforeMount(() => {
  form.bio = profile.bio ?? ''
  form.links = profile.links ?? []
  form.tags = profile.tags ?? []
})

const getFilteredDataFunc =(response) => {
  return response.data.suggestions.data
}

const formSubmit = ()=>{
  form.put(route('profile.update', profile.screen_name), {
    preserveScroll: true,
    onSuccess: () => {
      console.log('success')
    },
    onError: () => {
      console.error(form.errors)
    },
  })
}

const errors = computed(() => parseErrors(form.errors))

</script>

<template>
  <FormCard ref="formCard">
    <template #title>
      <div class="flex w-full items-center justify-between">
        プロフィール編集
        <Link :href="route('profile.show', profile.screen_name)" class="btn btn-neutral btn-sm">
          profileへ移動
        </Link>
      </div>
    </template>

    <TextareaElement
      v-model="form.bio"
      label-icon-type="wysiwygEditor"
      label="プロフィール"
      :error="form.errors.bio"
      help="プロフィールを記入してください。"
      auto-resize />

    <GridElement
      v-model="form.links"
      label="リンク"
      label-icon-type="link"
      :errors="errors.links"
      help="外部リンクを追加できます。"
      :colum-defs="columDefs" />

    <MultiSearchableElement
      v-model="form.tags"
      label="タグ"
      label-icon-type="tag"
      item-type="tag"
      help="複数選択可能です。"
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

    <template #actions>
      <ActionMessage :on="form.recentlySuccessful" class="mr-3">
        {{ $t('Saved.') }}
      </ActionMessage>

      <button class="btn btn-primary btn-md" @click="formSubmit(true)">
        保存する
      </button>
    </template>
  </FormCard>
</template>
<style scoped>

</style>
