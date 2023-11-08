<script setup>
const props = defineProps({
  name: {
    type: String,
    required: true
  },
  join_at: {
    type: String,
    required: true
  },
  location: {
    type: String,
    required: true
  },
  languages: {
    type: Array,
    required: true
  },
  links: {
    type: Array,
    required: true
  }
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
        <span class="">{{ name }}</span>
      </li>
      <li class="flex border-b py-2">
        <span class="font-bold w-24">Joined:</span>
        <span class="">{{ join_at }}</span>
      </li>
      <li class="flex border-b py-2">
        <span class="font-bold w-24">Location:</span>
        <span class="">{{ location }}</span>
      </li>
      <li class="flex border-b py-2">
        <span cla ss="font-bold w-24">Languages:</span>
        <div class="flex gap-2">
          <div v-for="language in languages" class="border border-base-content rounded-full">
            <Icon :icon="'circle-flags:' + language" class="text-xl"></Icon>
          </div>
        </div>
      </li>
      <li class="flex items-center border-b py-2">
        <span class="font-bold w-24">Links:</span>
        <LinkExts class="flex gap-1" :links="links"></LinkExts>
      </li>
    </ul>
  </Card>
</template>
