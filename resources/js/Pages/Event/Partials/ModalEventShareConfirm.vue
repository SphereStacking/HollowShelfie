<script setup>
import { openShareWindow } from '@/Utils/share'
import { generateEventAdminShareText, generateEventOrganizerShareText, generateEventParticipantShareText } from '@/Utils/domain/event'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
import { _eventPeriod } from '@/Utils/domain/event'
import { userHasPermission } from '@/Utils/domain/user'
import { useClipboard } from '@vueuse/core'

const IsOpenModal = ref(false)
const item = ref({})
const modalConfig = ref({
  title: '',
  text: ''
})

const generateShareText = (newItem) => {
  if (userHasPermission('event-announcement-publisher')){
    modalConfig.value.title = '告知用のPostを投稿しますか?'
    return generateEventAdminShareText({
      title: newItem.title || '',
      period: _eventPeriod(newItem.start_date, newItem.end_date),
      platformNames: newItem.instances.map((instance) => instance.instance_type) || [],
      instanceNames: newItem.instances.map((instance) => instance.display_name) || [],
      organizerNames: newItem.organizers.map((organizer) => organizer.name) || [],
      performerNames: newItem.performers.map((performer) => performer.name) || [],
      categoryNames: newItem.category_names || [],
      tags: newItem.tags || [],
      url: route('event.show', newItem.alias) || ''
    })
  } else if (newItem.auth_user.is_owner){
    modalConfig.value.title = '告知用のPostを投稿しますか?'
    return generateEventOrganizerShareText({
      title: newItem.title || '',
      period: _eventPeriod(newItem.start_date, newItem.end_date),
      platformNames: newItem.instances.map((instance) => instance.instance_type) || [],
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
      platformNames: newItem.instances.map((instance) => instance.instance_type) || [],
      instanceNames: newItem.instances.map((instance) => instance.display_name) || [],
      period: _eventPeriod(newItem.start_date, newItem.end_date),
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

const isCopied = ref(false)
const { copy } = useClipboard()
const copyToClipboard = () => {
  copy(item.value)
  isCopied.value = true
  setTimeout(() => {
    isCopied.value = false
  }, 2000)
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
      <div class=" mx-auto flex flex-row gap-2">
        <button class="btn btn-outline btn-neutral btn-sm" @click="onBtnCloseModal()">
          キャンセル
        </button>
        <button class="btn btn-neutral btn-sm" @click="shareOnX">
          <IconTypeMapper type="x" class="size-5" />へ投稿
        </button>
        <button class="btn btn-neutral btn-sm" @click="shareOnMisskey">
          <IconTypeMapper type="misskey" class="size-5" />へ投稿
        </button>
        <button class="btn btn-neutral btn-sm transition-all" :class="[isCopied ? 'text-success' : '']" @click="copyToClipboard">
          <IconTypeMapper type="copy" class="size-5" />
          <p class="text-sm ">
            {{ isCopied ? 'Copied' : 'Copy' }}
          </p>
        </button>
      </div>
    </template>
  </DialogModal>
</template>
