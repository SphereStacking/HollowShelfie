<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  type: {
    type: String,
    required: true
  },
});

const iconTypes = {
  'category': 'mdi:shape',
  'tag': 'mdi:tag',
  'title': 'mdi:subtitles-outline',
  'user': 'mdi:account',
  'status': 'mdi:alarm-light',
  'instance': 'mdi:map-marker',
  'date': 'mdi:calendar',
  'other': 'mdi:dots-hexagon',
  'default': ''
};

const getIconForType = (type) => iconTypes[type] || iconTypes['default'];
</script>

<template>
  <Icon :icon="getIconForType(type)"></Icon>
</template>

