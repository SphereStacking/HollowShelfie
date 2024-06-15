<script setup>
import InputGridElement from '@/Components/Grid/InputGridElement.vue'
import TextareaGridElement from '@/Components/Grid/TextareaGridElement.vue'
import draggable from 'vuedraggable'
import { generateUniqueId } from '@/Utils'
const draggableGroupId = generateUniqueId('grid')
const props = defineProps({
  columDefs: {
    type: Array,
    default: () => []
  },
  modelValue: {
    type: Array,
    default: () => []
  },
  errors: {
    type: Array,
    default: () => []
  }
})
const rowData= ref(props.modelValue)

// コンポーネントのマッピング
const componentsMap = {
  input: InputGridElement,
  textarea: TextareaGridElement,
}

const resolveComponent = (template) => {
  // コンポーネント名がマップに存在するか確認してから返す
  return componentsMap[template] ? componentsMap[template] : template
}
// ネストされた値を取得する関数
const getNestedValue = (obj, path, defaultValue = 'undefined') => {
  if (typeof path !== 'string' || !path) {
    return defaultValue
  }
  return path.split('.').reduce((o, p) => o ? o[p] : defaultValue, obj)
}
// ネストされた値を設定する関数
const setNestedValue = (obj, path, value) => {
  const keys = path.split('.')
  const lastKey = keys.pop()
  const lastObj = keys.reduce((o, key) => o[key] = o[key] || {}, obj)
  lastObj[lastKey] = value
}

const rowDelete = (index) => {
  rowData.value = [...rowData.value.slice(0, index), ...rowData.value.slice(index + 1)]
}

const createNewRow = () => {
  const newRow = {}

  props.columDefs.forEach(col => {
    if (col.field && col.field.includes('.')) {
      const keys = col.field.split('.')
      let currentPart = newRow

      keys.forEach((key, index) => {
        if (index === keys.length - 1) {
          currentPart[key] = ''
        } else {
          currentPart[key] = currentPart[key] || {}
          currentPart = currentPart[key]
        }
      })
    } else if (col.field) {
      newRow[col.field] = col.getNewRowValue? col.getNewRowValue() : null
    }
  })

  rowData.value.push(newRow)
}

const emit = defineEmits(['update:modelValue'])
watch(rowData, () => {
  emit('update:modelValue', rowData.value)
})
</script>
<template>
  <div class="w-full rounded-lg bg-base-100 ">
    <div class="h-2 rounded-t-lg">
    </div>
    <table class="table table-xs w-full rounded-lg ">
      <!-- head -->
      <thead class="">
        <tr>
          <td v-for="(col, colIndex) in columDefs" :key="'col-head-' + colIndex" :style="{ width: col['width'] }">
            {{ col['headerName'] }}
          </td>
        </tr>
      </thead>
      <draggable
        v-model="rowData"
        :group="draggableGroupId"
        item-key="id"
        tag="tbody"
        @start="dragging=true"
        @end="dragging=false">
        <template #item="{element ,index}">
          <tr :key="'row-'+index">
            <td v-for="col in columDefs " :key="'col-'+col.field">
              <div class=" flex size-full items-center justify-center ">
                <!-- コンポーネントを動的にレンダリング -->
                <component
                  :is="resolveComponent(col.template)"
                  v-if="col.template"
                  :key="element"
                  :row-index="index"
                  :model-value="getNestedValue(element, col.field)"
                  :template-options="col['templateOptions']"
                  :data="row"
                  v-bind="col.options"
                  @update:model-value="(value) => setNestedValue(element, col.field, value)"
                  @row-delete="rowDelete" />
                <!-- テンプレートが指定されていない場合は通常のテキストを表示 -->
                <span v-else>
                  {{ getNestedValue(element, col.field) }}
                </span>
              </div>
              <span v-if="errors && errors[index] && errors[index][col.field]" class="text-error">
                {{ errors[index][col.field] }}
              </span>
            </td>
          </tr>
        </template>
      </draggable>

      <tr></tr>
    </table>
    <div class="rounded-b-lg p-2">
      <slot name="footer" :create-new-row="createNewRow">
        <div class="flex w-full flex-row gap-2 py-1">
          <button class="btn btn-primary btn-sm" @click="createNewRow()">
            ADD row
          </button>
        </div>
      </slot>
    </div>
  </div>
</template>
<style lang="">

</style>
