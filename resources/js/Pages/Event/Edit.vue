<script setup>

function error() {
  console.error('EventEditForm error')
}

const modalEventUpdateSuccess = ref(null)
const modalEventShare = ref(null)

</script>

<template>
  <AppLayout title="Event Edit">
    <ModalEventShareConfirm ref="modalEventShare" />
    <ModalEventUpdateSuccess ref="modalEventUpdateSuccess" @share="modalEventShare.onBtnOpenModal($event)" />
    <template #header>
      <h2 class="text-xl font-semibold  leading-tight text-base-content">
        Event Edit
      </h2>
    </template>
    <div class="mx-auto mt-10 flex max-w-4xl flex-col gap-5 ">
      <EventEditFormCard @success="modalEventUpdateSuccess.onBtnOpenModal($event)" @error="error" />
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
