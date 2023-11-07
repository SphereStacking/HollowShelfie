
<script setup>
import { useForm, Link, router } from '@inertiajs/vue3';

const props = defineProps({
  event: {
    type: Object,
    required: true
  },
  tags: {
    type: Array,
    required: true
  },
})

const name = '名無し太郎'
const date = props.event ?? '?'
</script>

<template>
  <CardArticle>
    <template #header>
      <div class="flex flex-row justify-between ">
        <span class="text-md ">{{ props.event.start_date }} ～ {{ props.event.end_date }}</span>
        <BtnSnsShare class="flex flex-row gap-1"></BtnSnsShare>
      </div>
    </template>
    <template #content>
      <div class="flex gap-2">
        <LinkBadges :route="route('event.list.index')" :tags="tags"></LinkBadges>
      </div>
      <div class=" prose lg:prose-xl">
        <h1> {{ props.event.title }}</h1>

        {{ props.event.description }}

        <!-- {{ props.event }} -->
      </div>
    </template>
  </CardArticle>
</template>

<style lang="">

</style>


