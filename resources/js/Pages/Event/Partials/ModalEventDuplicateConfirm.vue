<script setup>
import {router } from '@inertiajs/vue3'

const IsOpenModal = ref(false)

//Modal閉じる。
const onBtnCloseModal = () => {
  IsOpenModal.value = false
  confirm.value = false
}
const item = ref({})

//Modal表示する。
const onBtnOpenModal = (newItem) => {
  IsOpenModal.value = true
  item.value = {
    id: newItem.id,
    alias: newItem.alias,
    title: newItem.title,
  }
}

const duplicateEvent = (id) => {
  router.post(route('event.duplicate', id), {
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

const confirm = ref(false)

</script>

<template>
  <DialogModal :show="IsOpenModal" @close="onBtnCloseModal">
    <template #title>
      <p class="mx-auto w-3/4 text-left ">
        複製しますか？
      </p>
    </template>

    <template #content>
      <div class="mx-auto w-3/4 text-left text-lg">
        <p>
          <span class="font-bold">「<span class="text-warning">{{ item.title }}</span></span>」を複製します。<br>
          注意：フライヤー画像は複製されません。<br>
          複製後、必要に応じてフライヤー画像を再設定してください。
        </p>
        <div class="mt-5 flex flex-row items-center gap-2">
          <input
            id="confirm"
            v-model="confirm" type="checkbox" checked="checked"
            class="checkbox-warning checkbox  bg-transparent">
          <label for="confirm" class="text-sm">確認しました</label>
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
