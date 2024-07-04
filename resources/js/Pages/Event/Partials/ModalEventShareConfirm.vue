<script setup>
import { openShareWindow } from '@/Utils/share'
import { generateEventOrganizerShareText, generateEventParticipantShareText } from '@/Utils/domain/event'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
import { _eventPeriod } from '@/Utils/domain/event'

const IsOpenModal = ref(false)
const item = ref({})
const modalConfig = ref({
  title: '',
  text: ''
})

const props = defineProps({
  mode: {
    type: String,
    required: true,
    validator: (value) => ['admin', 'participant'].includes(value)
  }
})

const generateShareText = (newItem) => {
  if (props.mode === 'admin') {
    modalConfig.value.title = ' SNSへ告知を投稿しますか？'
    return generateEventOrganizerShareText({
      title: newItem.title || '',
      period: _eventPeriod(newItem.start_date, newItem.end_date),
      instanceNames: newItem.instances.map((instance) => instance.display_name) || [],
      organizerNames: newItem.organizers.map((organizer) => organizer.name) || [],
      performerNames: newItem.performers.map((performer) => performer.name) || [],
      categoryNames: newItem.category_names || [],
      tags: newItem.tags || [],
      url: route('event.show', newItem.alias) || ''
    })
  } else {
    modalConfig.value.title = 'イベントへの参加を表明しますか？'
    return generateEventParticipantShareText({
      title: newItem.title || '',
      period: _eventPeriod(newItem.start_date, newItem.end_date),
      instanceNames: newItem.instances.map((instance) => instance.display_name) || [],
      organizerNames: newItem.organizers.map((organizer) => organizer.name) || [],
      performerNames: newItem.performers.map((performer) => performer.name) || [],
      categoryNames: newItem.category_names || [],
      tags: newItem.tags || [],
      url: route('event.show', newItem.alias) || ''
    })
  }
}
//Modal表示する。
const onBtnOpenModal = (newItem) => {
  IsOpenModal.value = true
  item.value = generateShareText(newItem)
}

//Modal閉じる。
const onBtnCloseModal = () => {
  IsOpenModal.value = false
  confirm.value = false
}

defineExpose({
  onBtnCloseModal,
  onBtnOpenModal
})

const confirm = ref(false)

const shareOnX = () => {
  openShareWindow('x', {
    text: item.value
  })
}
const shareOnMisskey = () => {
  openShareWindow('misskey', {
    text: item.value
  })
}
</script>

<template>
  <DialogModal :show="IsOpenModal" @close="onBtnCloseModal">
    <template #title>
      <p class="mx-auto w-3/4 text-left ">
        {{ modalConfig.title }}
      </p>
    </template>

    <template #content>
      <div class="mx-auto w-3/4 text-left text-lg">
        <TextareaElement
          v-model="item"
          label-icon-type="wysiwygEditor"
          label="投稿文"
          help=""
          auto-resize />
      </div>
    </template>

    <template #footer>
      <div class="grid w-full grid-cols-4 gap-2">
        <button class="btn btn-outline btn-neutral btn-sm col-span-1 col-start-2" @click="onBtnCloseModal()">
          キャンセル
        </button>
        <div class="flex flex-row gap-2">
          <button class="btn btn-neutral btn-sm" @click="shareOnX">
            <IconTypeMapper type="x" class="size-5" />へ投稿
          </button>
          <button class="btn btn-neutral btn-sm" @click="shareOnMisskey">
            <IconTypeMapper type="misskey" class="size-5" />へ投稿
          </button>
        </div>
      </div>
    </template>
  </DialogModal>
</template>
