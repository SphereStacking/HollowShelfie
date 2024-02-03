<script setup>
import InputGridElement from '@/Components/Grid/InputGridElement.vue'
import TextareaGridElement from '@/Components/Grid/TextareaGridElement.vue'
const props = defineProps({
  columDefs: {
    type: Array,
    default: () => []
  },
  modelValue: {
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

//引数のcolumnDefsをもとに、再帰的に「'field名'=''」の連想配列を生成する。
const parseGridHeaderRecursivelyAndAddLine = (newData, columnDefs)=>{
  console.log(columnDefs)

  // if (Array.isArray(columnDefs)){ return newData }
  for (let i=0 ; i < columnDefs?.length ; i++){
    let item = columnDefs[i]
    if (item['children'] != null){
      parseGridHeaderRecursivelyAndAddLine(newData, columnDefs['children'])
    } else {
      //fieldが空の時は追加しない。
      console.log(item['field'])
      if (item['field'] != ''){ newData[item['field']] }
    }
  }
  return newData
}

const rowDelete = (index) => {
  rowData.value = [...rowData.value.slice(0, index), ...rowData.value.slice(index + 1)]
}

const createNewRow = (columDefs) => {
  const newRow = {}

  columDefs.forEach(col => {
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
      newRow[col.field] = null
    }
  })

  rowData.value.push(newRow)
}

</script>
<template>
  <div class=" w-full rounded-lg ">
    <div class="h-2 rounded-t-lg bg-base-300">
    </div>
    <table class="table table-xs w-full rounded-lg">
      <!-- head -->
      <thead class=" bg-base-300">
        <tr>
          <td v-for="(col, colIndex) in columDefs" :key="'col-head-' + colIndex" :style="{ width: col['width'] }">
            {{ col['headerName'] }}
          </td>
        </tr>
      </thead>
      <tbody class="bg-base-100">
        <tr v-for="(row,rowIndex) in rowData" :key="'row-'+row.rowIndex">
          <td v-for="col in columDefs " :key="'col-'+col.field">
            <!-- コンポーネントを動的にレンダリング -->
            <component
              :is="resolveComponent(col.template)"
              v-if="col.template"
              :key="row"
              :row-index="rowIndex"
              :model-value="getNestedValue(row, col.field)"
              :template-options="col['templateOptions']"
              :data="row"
              @update:model-value="(value) => setNestedValue(row, col.field, value)"
              @row-delete="rowDelete" />
            <!-- テンプレートが指定されていない場合は通常のテキストを表示 -->
            <span v-else>
              {{ getNestedValue(row, col.field) }}
            </span>
          </td>
        </tr>
        <tr>
          <td :colspan="columDefs.length">
            <div class="flex w-full flex-row gap-2 py-1">
              <button class="btn btn-primary btn-sm" @click="createNewRow(columDefs)">
                ADD row
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="h-2 rounded-b-lg bg-base-100">
    </div>
  </div>
</template>
<style lang="">

</style>
