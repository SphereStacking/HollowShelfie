<script setup>

const props = defineProps({
  organizers: {
    type: Array,
    default: () => [],
    required: true
  },
})
</script>

<template>
  <div class="card card-compact bg-base-200 shadow-xl">
    <div class="card-body">
      <h2 class="card-title">
        オーガナイザー
      </h2>
      <div class=" flex flex-col gap-2 items-center">
        <template v-for="(organizer, index ) in props.organizers">
          <div class="card card-compact bg-base-300 w-full">
            <div class="card-body gap-0.5">
              <dl class="avatar">
                <dt  class="h-48 mx-auto "><img :src="organizer.image_url" class="rounded-md" /></dt>
              </dl>
              <dl>
                <dt class="text-sm font-bold text-gray-900 uppercase ">name</dt>
                <dd class="ml-2">
                  <a href='#' class="flex flex-row items-center gap-1">
                    {{ organizer.name }}
                  </a>
                </dd>
              </dl>
              <dl>
                <dt class=" text-sm font-bold text-gray-900 uppercase ">Links</dt>
                <dd v-for="(item, index ) in organizer.links" class="ml-2 text-sm text-gray-500  hover:underline">
                  <a href='item.link' class="flex flex-row items-center gap-0.5">
                    <Icon icon="ph:link-bold"></Icon>
                    {{ item.label }}
                  </a>
                </dd>
              </dl>
            </div>
          </div>
          <Icon v-if="index !== props.organizers.length - 1" icon="oi:x" class="h-10 w-10" />
        </template>
      </div>
    </div>
  </div>
</template>

<style lang="">

</style>
