<script setup>
const IsOpenModal = ref(false)

//Modal閉じる。
const onBtnCloseModal = () => {
  IsOpenModal.value = false
}

const item = ref({})

//Modal表示する。
const onBtnOpenModal = (newItem) => {
  IsOpenModal.value = true
  console.log(newItem)
  item.value = {
    id: newItem.id,
    alias: newItem.alias,
    title: newItem.title,
    status: newItem.status,
    status_label: newItem.status_label,
    start_date: newItem.start_date,
    end_date: newItem.end_date,
    period: newItem.period,
    url: route('event.show', newItem.alias),
    instances: newItem.instances.map((instance) => instance.instance_type_name+ ' '+instance.display_name).join(''),
    organizers: newItem.organizers.map((organizer) => organizer.name).join('、'),
    performers: newItem.performers.map((performer) => performer.name).join('、'),
    category_names: newItem.category_names.map((category) => category).join('、'),
    tags: newItem.tags.map((tag) => '#'+tag).join(' '),
  }
}

function getShareText() {
  return `✨ ${item.value.title}\n` +
   `🗓 ${item.value.period}\n` +
   `📍 ${item.value.instances}\n` +
   `👥 ${item.value.organizers}\n` +
   `🎤 ${item.value.performers}\n` +
   `🧺 ${item.value.category_names}\n` +
   `🏷 #vShelf ${item.value.tags}\n` +
   `🔗 ${item.value.url}\n`
}

const linklabel = computed(() => {
  return item.value.status === 'draft' ? 'プレビューページ' : '公開ページ'
})
defineExpose({
  onBtnCloseModal,
  onBtnOpenModal
})
</script>

<template>
  <DialogModal :show="IsOpenModal" @close="onBtnCloseModal">
    <template #title>
      <div class="w-full text-center">
        保存しました。
      </div>
    </template>

    <template #content>
      <div class="flex w-full flex-col items-center">
        <p>{{ item.title }} </p>
        <a class="btn btn-link" :href="route('event.show', item.alias)">{{ linklabel }}</a>
        <BtnSnsShare v-if="item.status !== 'draft'" :text="getShareText()" />
      </div>
    </template>

    <template #footer>
      <div class="grid w-full grid-cols-4 gap-2">
        <button class="btn btn-outline btn-neutral btn-sm col-span-1 col-start-2" @click="onBtnCloseModal()">
          編集を続ける
        </button>
        <a class="btn btn-neutral btn-sm col-span-1 col-start-3" :href="route('event.manage')">
          管理画面へ
        </a>
        <div class="col-span-full"></div>
        <a class="btn btn-link btn-sm col-span-2 col-start-2" :href="route('dashboard')">
          ダッシュボードへ
        </a>
      </div>
    </template>
  </DialogModal>
</template>
