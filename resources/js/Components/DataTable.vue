<script setup>
import PerformerLink from './DataTableComponents/PerformerLink.vue'; // 上で作成したコンポーネントをインポート


const props = defineProps({
  columDefs: Array,
  rowData: Array
});

// カラム定義と行データのデフォルト値（必要に応じて）
// props.columDefs = ref([
//   { headerName: 'Row ID', field: 'id', },
//   { headerName: 'Row make', field: 'make', template: 'link' },
//   { headerName: 'Row model', field: 'model', },
//   { headerName: 'Row price', field: 'price', },
// ]);
// props.rowData = ref([
//   { headerName: 'Row ID', field: 'id', },
//   { headerName: 'Row make', field: 'make', template: 'link' },
//   { headerName: 'Row model', field: 'model', },
//   { headerName: 'Row price', field: 'price', },
// ]);
// コンポーネントのマッピング
const componentsMap = {
  link: PerformerLink,
};

const resolveComponent = (template) => {
  // コンポーネント名がマップに存在するか確認してから返す
  return componentsMap[template] ? componentsMap[template] : null;
};
// ネストされた値を取得する関数
const getNestedValue = (obj, path, defaultValue = 'undefined') => {
  return path.split('.').reduce((o, p) => (o ? o[p] : defaultValue), obj);
};
</script>
<template>
  <div class="rounded-lg border-4 overflow-x-auto">
    <table class="table table-md">
      <!-- head -->
      <thead>
        <tr>
          <td v-for="(col, colIndex) in props.columDefs" :key="'col-head-' + colIndex">
            {{ col['headerName'] }}
          </td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in props.rowData || defaultRowData" :key="row.id">
          <td v-for="col in props.columDefs || defaultColumnDefs" :key="col.field">
            <!-- コンポーネントを動的にレンダリング -->
            <component v-if="col.template" :is="resolveComponent(col.template)" :data="row" />
            <!-- テンプレートが指定されていない場合は通常のテキストを表示 -->
            <span v-else>
              {{ getNestedValue(row, col.field) }}
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<style lang="">

</style>
