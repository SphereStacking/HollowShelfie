<script setup>

function error() {
  console.error('EventEditForm error')
}

const modal = ref()
const modalEventShare = ref(null)
const openModal = (value) => { modal.value.onBtnOpenModal(value) }

</script>

<template>
  <AppLayout title="Event Edit">
    <ModalEventShareConfirm ref="modalEventShare" mode="admin" />
    <template #header>
      <h2 class="text-xl font-semibold  leading-tight text-base-content">
        Event Create
      </h2>
    </template>
    <div class="mx-auto mt-10 flex max-w-4xl flex-col gap-5 ">
      <EventEditFormCard @success="openModal" @error="error" />
    </div>
    <ModalEventUpdateSuccess ref="modal" @share="modalEventShare.onBtnOpenModal($event)" />
  </AppLayout>
</template>

<style lang="">

</style>
