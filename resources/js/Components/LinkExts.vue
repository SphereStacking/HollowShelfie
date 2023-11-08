<script setup>
defineProps({
  links: String
});
</script>

<template>
  <div>
    <a class="link flex felx-row items-center gap-0.5" :href="item.link" v-for="item in links">
      <Icon icon="ph:link-bold"></Icon>
      {{ item.label }}
    </a>
  </div>
</template>
