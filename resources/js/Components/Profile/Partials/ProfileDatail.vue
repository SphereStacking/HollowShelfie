<script setup>
const props = defineProps({
  profile: {
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
    <h4 class="text-xl  font-bold">Profile</h4>
    <ul class="mt-2 ">
      <li class="flex border-y py-2">
        <span class="font-bold w-24">Name:</span>
        <span class="">{{ profile.name }}</span>
      </li>
      <li class="flex border-b py-2">
        <span class="font-bold w-24">Joined:</span>
        <span class="">{{ profile.created_at }}</span>
      </li>
      <li class="flex border-b py-2">
        <span class="font-bold w-24">Location:</span>
        <span class="">日本,東京</span>
      </li>
      <li class="flex border-b py-2">
        <span class="font-bold w-24">Languages:</span>
        <div class="flex gap-2">
          <div class="border border-base-content rounded-full">
            <Icon icon="circle-flags:jp" class="text-xl"></Icon>
          </div>
          <div class="border border-base-content rounded-full">
            <Icon icon="circle-flags:kr" class="text-xl"></Icon>
          </div>

        </div>
      </li>
      <li class="flex items-center border-b py-2">
        <span class="font-bold w-24">Links:</span>
        <div class="flex gap-2">
          <Icon icon="logos:github-icon" class="text-xl"></Icon>
          <Icon icon="logos:discord-icon" class="text-xl"></Icon>
          <Icon icon="logos:soundcloud" class="text-xl"></Icon>
          <Icon icon="logos:twitch" class="text-xl"></Icon>
        </div>
      </li>
    </ul>
  </Card>
</template>
