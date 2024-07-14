<script setup>

defineProps({
  instances: {
    type: Array,
    required: true
  }
})

</script>
<template>
  <div v-if="instances.length > 0" class="flex w-full flex-col  justify-center">
    <div class="flex flex-row items-center gap-1">
      <IconTypeMapper type="instance" />
      <div>access</div>
    </div>
    <div class="flex w-full flex-col rounded-xl bg-base-200">
      <template v-for="(instance, index) in instances" :key="index">
        <div class="flex flex-row gap-2 overflow-hidden p-2">
          <div class="badge badge-primary">
            {{ instance.instance_type }}
          </div>
          <component
            :is="instance.access_url ? 'a' : 'div'"
            :href="instance.access_url || undefined"
            class=" whitespace-nowra truncate"
            :class="{ 'link': instance.access_url }">
            {{ instance.display_name }}
          </component>
        </div>
      </template>
    </div>
  </div>
</template>
<style>

</style>
