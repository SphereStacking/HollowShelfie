<script setup>

function success() {
  console.log('success')
}

function error() {
  console.log('error')
}

const modal = ref()
const openModal = (value) => { modal.value.onBtnOpenModal(value) }

</script>

<template>
  <AppLayout title="Event Edit">
    <template #header>
      <h2 class="text-xl font-semibold  leading-tight text-base-content">
        Event Edit
      </h2>
    </template>
    <div class="mx-auto mt-10 flex max-w-4xl flex-col gap-5 ">
      <EventEditFormCard @success="openModal" @error="error" />
    </div>
    <ModalEventUpdateSuccess ref="modal" />
  </AppLayout>
</template>

<style lang="">

</style>
