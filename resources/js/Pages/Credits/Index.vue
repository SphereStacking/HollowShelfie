<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';
</script>

<template>
  <AppLayout title="credits">
    <template #header>
      <h2 class="font-semibold text-xl  leading-tight">
        クレジット
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          robohashのライセンス条項を要確認する。
        </div>
      </div>
    </div>
  </AppLayout>
</template>
