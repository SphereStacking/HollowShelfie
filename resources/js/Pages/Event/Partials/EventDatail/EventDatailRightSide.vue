
<script setup>
import { useForm, Link, router } from '@inertiajs/vue3';

const props = defineProps({
  event: {
    type: Object,
    required: true
  },
  recommendEvents: {
    type: Array,
    default: () => []
  },
  trendTags: {
    type: Array,
    default: () => []
  }
})

//organizerも1人ではないよね。
// const organizers = [
//   { id: 1, name: 'ほげ太郎', img: '', links: ['x', 'booth', 'soundcloud'], oneWord: 'ほげ~~~' },
//   { id: 1, name: 'ふが次郎', img: '', links: ['x',], oneWord: 'ふがふがぁ！！' }
// ]
// const organizers = props.event.team_organizers;

// const organizers = props.event.user_organizers;
</script>

<template>
  <aside>
    <div class="sticky top-36 flex-col  flex gap-4">
      <h3 id="sidebar-right" class="sr-only">Sidebar</h3>
      <!-- 人気のタグ -->
      <Card class="w-full bg-transparent border">
        <template #title>
          <h4 class="font-bold uppercase ">ここに広告を表示したい</h4>
        </template>
      </Card>
      <!-- organizer profile -->
      <CardOrganizers :organizers="organizers"></CardOrganizers>
      <!-- 人気のタグ -->
      <Card class="w-full">
        <template #title>
          <h4 class="font-bold uppercase ">人気のタグ</h4>
        </template>
        <template #content>
          <div class="flex flex-wrap gap-1">
            <div v-for="tag in trendTags" class="badge">{{ tag }}</div>
          </div>
        </template>
      </Card>
      <!-- 関連記事 -->
      <Card class="w-full">
        <figure><img src="/images/stock/photo-1635805737707-575885ab0820.jpg" alt="Movie" /></figure>
        <template #title>
          関連イベント
        </template>
        <template #content>
          <div v-for="event in recommendEvents">
            {{ event.title }}
          </div>
        </template>
      </Card>
      <!-- コミュニティスポンサー -->
      <Card class="w-full">
        <template #title>
          スポンサー
        </template>
        <template #content>
          <p>誰もいないよ😿</p>
          <p>まってるよ！</p>
        </template>
      </Card>
    </div>
  </aside>
</template>

<style lang="">

</style>


