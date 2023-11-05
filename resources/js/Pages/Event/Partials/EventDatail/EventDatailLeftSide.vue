
<script setup>
import { useForm, Link, router } from '@inertiajs/vue3';

const props = defineProps({
  performers: {
    type: Array,
    required: true
  },
})

import file1 from '../LXIX_Design_224-4.png'
import file2 from '../LXIX_Design_225-5.png'
import file3 from '../LXIX_Design_196-4.png'

const image_flyers = [
  file1,
  file2,
  file3,
]
const columDefs = [
  { headerName: '出演者', field: 'name', template: 'link' },
  { headerName: '時間', field: 'pivot.performance_time' },
]
const rowData = props.performers
// [
//   { id: 1, performer: 'ほげ太郎', tags: 'House,Progressive House', time: '19:00~21:00' },
//   { id: 2, performer: 'ふが次郎', tags: 'Trance,Techno', time: '21:00~22:00' },
//   { id: 3, performer: 'ぴよ三郎', tags: 'Deep House', time: '22:00~23:00' },
// ]
</script>

<template>
  <aside>
    <div class="sticky top-36">
      <h3 id="sidebar-left" class="sr-only">Sidebar</h3>
      <CarouselGallery :images=image_flyers></CarouselGallery>

      <DataTable :colum-defs="columDefs" :row-data="rowData" class="mt-4" />
    </div>

  </aside>
</template>

<style lang="">

</style>


