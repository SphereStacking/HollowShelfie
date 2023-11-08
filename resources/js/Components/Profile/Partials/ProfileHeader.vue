<script setup>
const props = defineProps({
  header: {
    type: String,
    required: true
  },
})
defineEmits(
  ['click']
)
</script>
<template>
  <Card class="">
    <template #top>
      <figure>
        <img src="https://vojislavd.com/ta-template-demo/assets/img/profile-background.jpg" class="">
      </figure>
    </template>
    <div class="flex flex-col items-center -mt-20">
      <img :src="header.profile_photo_url" class="w-40 border-4 border-white rounded-full">
      <div class="flex items-center space-x-2 mt-2">
        <p class="text-2xl">{{ header.name }}</p>
        <span class="bg-blue-500 rounded-full p-1" title="Verified">
          <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100 h-2.5 w-2.5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
          </svg>
        </span>
      </div>
      <p class="text-gray-700">hoge</p>
    </div>
    <div class="flex-1 flex flex-col items-center lg:items-end justify-end px-8 mt-2">
      <div class="flex items-center space-x-4 mt-2">
        <button class="btn btn-circle  btn-primary">
          <Icon icon="line-md:bell" class="text-xl"></Icon>
        </button>
        <button class="btn btn-primary">
          <Icon icon="line-md:account-add" class="text-xl"></Icon>
          Follow
          <div class="badge">+99</div>
        </button>
        <button class="btn btn-neutral flex flex-row">
          <Icon icon="line-md:email" class="text-xl"></Icon>
          Connect
        </button>
      </div>
    </div>
  </Card>
</template>
