<script setup lang="ts">
import { Head } from '@inertiajs/vue3'

type MetaTag = {
  content: string
} & (
  | { name: string; property?: never }
  | { property: string; name?: never }
)

type Props = {
  metaTags: MetaTag[]
}

defineProps<Props>()

</script>

<template>
  <Head>
    <meta
      v-for="(tag, index) in metaTags"
      :key="index"
      :head-key="tag.name ?? tag.property"
      v-bind="tag">
  </Head>
</template>
