<script setup>
const IsDispModal = ref()

//Modal閉じる。
const onBtnCloseModal = () => {
  IsDispModal.value = false
}
//Modal表示する。
const onBtnOpenModal = () => {
  IsDispModal.value = true
}

defineExpose({
  onBtnCloseModal,
  onBtnOpenModal
})
</script>

<template>
  <DialogModal :show="IsDispModal" @close="onBtnCloseModal">
    <template #title>
      検索条件について
    </template>

    <template #content>
      <div class="flex flex-col gap-2 text-sm">
        <div class="flex flex-col">
          <div class="flex flex-row">
            <IconTypeMapper type="union" class="text-xl" /> 「または」
          </div>
          いずれかの条件に一致する結果を表示します。
        </div>
        <div class="flex flex-col">
          <div class="flex flex-row">
            <IconTypeMapper type="intersect" class="text-xl" /> 「かつ」
          </div>
          全ての条件に一致する結果のみを表示します。
        </div>
        <div class="flex flex-col">
          <div class="flex flex-row">
            <IconTypeMapper type="exclude" class="text-xl" /> 「除く」
          </div>
          特定の条件を除外して結果を表示します。
        </div>
      </div>
    </template>

    <template #footer>
      <div class="grid grid-cols-5 ">
        <div class="col-start-2 col-end-5 flex justify-between">
          <button class="btn btn-info btn-sm" @click="onBtnCloseModal()">
            OK
          </button>
        </div>
      </div>
    </template>
  </DialogModal>
</template>
