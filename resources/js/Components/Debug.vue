<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
const page = usePage().props

const props = defineProps({
  object: Object
});

let opened = ref({});

const toggle = (key) => {
  opened.value[key] = !opened.value[key];
};

const objectOrPage = computed(() => {
  return props.object && Object.keys(props.object).length > 0 ? props.object : page;
});
</script>

<template>
  <ul class="pl-4">
    <li v-for="(value, key) in  objectOrPage " :key="key">
      <span v-if="typeof value === 'object'" class=" text-primary cursor-pointer hover:text-accent transition-all"
        @click="toggle(key)" :class="{ 'text-blue-500': typeof value === 'object' }">{{ key }}:</span>
      <span v-else class="flex felx-row">
        <div class=" text-primary">{{ key }}</div>
        <div>: {{ value }}</div>
      </span>
      <span class=" cursor-pointer" v-if="typeof value === 'object' && !opened[key]" @click="toggle(key)">{...}</span>
      <div v-if="opened[key]">
        <div v-if="typeof value === 'object'">
          <ul class="pl-4">
            <Debug :object="value" />
          </ul>
        </div>
        <div v-else>
          {{ value }}
        </div>
      </div>
    </li>
  </ul>
</template>
