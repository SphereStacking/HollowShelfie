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
  console.log(newItem)
  item.value = {
    title: newItem.title,
    id: newItem.id,
  }
}

const deleteEvent = (id) => {
  router.delete(route('event.destroy', id), {
    preserveScroll: true
  })
  onBtnCloseModal()
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
      <div class="mx-auto w-3/4 text-left ">
        削除しますか？
      </div>
    </template>

    <template #content>
      <div class="mx-auto w-3/4 text-left text-lg">
        この操作を実行すると、<span class="text-lg font-bold">{{ item.title }}</span>は完全に削除され、<br>
        後から復元することはできません。<br>
        <br>
        <div class="flex flex-row items-center gap-2">
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
        <button :disabled="!confirm" class="btn btn-error btn-sm col-span-1 col-start-3" @click="deleteEvent(item.id)">
          削除
        </button>
      </div>
    </template>
  </DialogModal>
</template>
