<script setup>
const IsDispModal = ref();

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
});
</script>

<template>
  <DialogModal :show="IsDispModal" @close="onBtnCloseModal">
    <template #title>
      <slot>
      </slot>
    </template>

    <template #content>
      <div class="prose">
        <h4>検索条件にprefix記号を使用するとADD先を制御することができます</h4>
        <p>
          <strong class="text-error bg-neutral rounded-md px-2">+:</strong> または <br>
          ex) 「+:apple」と入力しADDすると「または」に「apple」条件が追加されます。
        </p>
        <p>
          <strong class="text-error  bg-neutral rounded-md px-2">*:</strong> かつ <br>
          ex) 「*:apple」と入力しADDすると「かつ」に「apple」が追加されます。
        </p>
        <p>
          <strong class="text-error  bg-neutral rounded-md px-2">-:</strong> 除く<br>
          ex) 「-:apple」と入力しADDすると「除く」に「apple」が追加されます。
        </p>
      </div>
    </template>

    <template #footer>
      <div class="grid grid-cols-5 ">
        <div class="flex col-start-2 col-end-5 justify-between">
          <button class="btn btn-info btn-sm" @click="onBtnCloseModal()">OK</button>
        </div>
      </div>
    </template>
  </DialogModal>
</template>
