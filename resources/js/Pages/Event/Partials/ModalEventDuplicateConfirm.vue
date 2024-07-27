<script setup>
import {router } from '@inertiajs/vue3'

const IsOpenModal = ref(false)
const item = ref({})
const confirm = ref(false)
const confirmTitle = ref('')

//Modal閉じる。
const onBtnCloseModal = () => {
  IsOpenModal.value = false
  confirm.value = false
}

//Modal表示する。
const onBtnOpenModal = (newItem) => {
  IsOpenModal.value = true
  confirmTitle.value = '[COPY] ' + newItem.title
  item.value = {
    id: newItem.id,
    alias: newItem.alias,
    title: newItem.title,
  }
}

const duplicateEvent = (id) => {
  router.post(route('event.duplicate', id), {
    title: confirmTitle.value,
    preserveScroll: true,
    onFinish: () => {
      onBtnCloseModal()
    }
  })
}

defineExpose({
  onBtnCloseModal,
  onBtnOpenModal
})

const warningTitle = computed(() => {
  if (confirmTitle.value.toLowerCase().includes('copy')) {
    return 'タイトルに「copy」が含まれています。適切か確認してください。'
  }
  return ''
})
</script>

<template>
  <DialogModal :show="IsOpenModal" @close="onBtnCloseModal">
    <template #title>
      <p class="mx-auto w-3/4 text-left ">
        複製しますか？
      </p>
    </template>

    <template #content>
      <div class="mx-auto flex w-3/4 flex-col gap-2 text-left text-lg">
        <p><strong class="font-bold">「<span class="text-warning">{{ item.title }}</span></strong>」</p>
        <p class="">
          <strong class="text-warning">注意</strong>
          <ul class="ml-4 list-outside list-disc text-sm">
            <li>下書きで複製されます。</li>
            <li>フライヤー画像は複製されません。<br>必要に応じてフライヤー画像を再設定してください。</li>
          </ul>
        </p>
        <TextElement
          v-model="confirmTitle"
          class="mt-2"
          label="新しいイベントのタイトル"
          :warning="warningTitle" />
        <div class="mt-5 flex flex-col gap-2">
          <div class="flex flex-row items-center gap-2">
            <input
              id="confirm"
              v-model="confirm" type="checkbox" checked="checked"
              class="checkbox-warning checkbox  bg-transparent">
            <label for="confirm" class="text-sm">確認しました</label>
          </div>
        </div>
      </div>
    </template>

    <template #footer>
      <div class="grid w-full grid-cols-4 gap-2">
        <button class="btn btn-outline btn-neutral btn-sm col-span-1 col-start-2" @click="onBtnCloseModal()">
          キャンセル
        </button>
        <button :disabled="!confirm" class="btn btn-warning btn-sm col-span-1 col-start-3" @click="duplicateEvent(item.alias)">
          複製
        </button>
      </div>
    </template>
  </DialogModal>
</template>
