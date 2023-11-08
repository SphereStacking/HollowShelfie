
<script setup>
import { useForm, Link, router } from '@inertiajs/vue3';

const props = defineProps({
  performers: {
    type: Array,
    required: true
  },
})

import file1 from '@/Components/LXIX_Design_224-4.png'
import file2 from '@/Components/LXIX_Design_225-5.png'
import file3 from '@/Components/LXIX_Design_196-4.png'

const image_flyers = [
  file1,
  file2,
  file3,
]
const columDefs = [
  { headerName: '', field: '', template: 'Img' },
  { headerName: '出演者', field: 'name', template: 'link' },
  { headerName: 'リンク', field: '', template: 'ExtLinks' },
  { headerName: '時間', field: 'pivot.performance_time' },
]
const rowData = props.performers
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


