<script setup>
const props=defineProps({
  id: {
    type: String,
    required: true
  },
  columDefs: {
    type: Array,
    required: false
  },
  rowData: {
    type: Array,
    required: false
  },
})

//データの例)
// columnDefs: [
//   { headerName: 'Row ID', field: 'id' },
//   { headerName: 'Row make',field: 'make' },
//   { headerName: 'Row model',field: 'model' },
//   { headerName: 'Row price',field: 'price' },
// ];
// rowData = [

//   { id: 'c2', make: 'Ford', model: 'Mondeo', price: 32000 },
//   { id: 'c8', make: 'Porsche', model: 'Boxster', price: 72000 },
//   { id: 'c4', make: 'BMW', model: 'M50', price: 60000 },
//   { id: 'c14', make: 'Aston Martin', model: 'DBX', price: 190000 },
// ];
</script>
<template>
  <div class="rounded-lg border-2">
    <table :id="id" class="table">
      <!-- head -->
      <thead>
        <tr>
          <td v-for="(col,colIndex) in props.columDefs" :key="'col-head-' + colIndex">
            {{ col['headerName'] }}
          </td>
        </tr>
      </thead>
      <!-- tbody -->
      <tbody>
        <tr v-for="(row,rowIndex) in rowData" :key="'row-'+rowIndex">
          <template v-for="(col,colIndex) in props. columDefs" :key="'col-body-' + colIndex">
            <td>{{ row[col.field] }}</td>
          </template>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<style lang="">

</style>
