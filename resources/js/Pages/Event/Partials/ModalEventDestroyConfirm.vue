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

const deleteEvent = (id) => {
  router.delete(route('event.destroy', id), {
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
      <p class="mx-auto w-3/4 text-left">
        削除しますか？
      </p>
    </template>

    <template #content>
      <div class="mx-auto w-3/4 text-left text-lg">
        <p>
          <span class="font-bold">「<span class="text-error">{{ item.title }}</span>」</span>
        </p>
        <p class="mt-2">
          <strong class="text-error">注意</strong>
          <ul class="ml-4 list-outside list-disc">
            <li>完全に削除され、後から復元することはできません。</li>
          </ul>
        </p>
        <div class="mt-5 flex flex-row items-center gap-2">
          <input
            id="confirm"
            v-model="confirm" type="checkbox" checked="checked"
            class="checkbox-error checkbox  bg-transparent">
          <label for="confirm" class="text-sm">確認しました</label>
        </div>
      </div>
    </template>

    <template #footer>
      <div class="grid w-full grid-cols-4 gap-2">
        <button class="btn btn-outline btn-neutral btn-sm col-span-1 col-start-2" @click="onBtnCloseModal()">
          キャンセル
        </button>
        <button :disabled="!confirm" class="btn btn-error btn-sm col-span-1 col-start-3" @click="deleteEvent(item.alias)">
          削除
        </button>
      </div>
    </template>
  </DialogModal>
</template>
