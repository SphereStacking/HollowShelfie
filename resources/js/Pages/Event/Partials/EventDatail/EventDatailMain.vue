
<script setup>
import { useForm, Link, router } from '@inertiajs/vue3';

const props = defineProps({
  created_at: {
    type: Date,
    required: true
  },
  start_date: {
    type: Date,
    required: true
  },
  end_date: {
    type: Date,
    required: true
  },
  tags: {
    type: Array,
    required: true
  },
  title: {
    type: String,
    required: true
  },
  description: {
    type: String,
    required: true
  },
})

</script>

<template>
  <CardArticle>
    <template #header>
      <div class="flex flex-row justify-between ">
        <span class="text-md ">{{ start_date }} ～ {{ end_date }}</span>
        <BtnSnsShare class="flex flex-row gap-1"></BtnSnsShare>
      </div>
    </template>
    <template #content>
      <div class="flex">
        <button class="btn btn-primary btn-sm rounded-md mr-1">Small</button>
        <LinkBadges :route="route('event.list.index')" :tags="tags"></LinkBadges>
      </div>
      <div class=" prose lg:prose-xl">
        <h1> {{ title }}</h1>
        {{ description }}
        <!-- {{ props.event }} -->
      </div>
    </template>
  </CardArticle>
</template>

<style lang="">

</style>


