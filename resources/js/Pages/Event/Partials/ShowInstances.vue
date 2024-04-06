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
      <div>instance</div>
    </div>
    <div class="flex w-full flex-col rounded-xl bg-base-200">
      <template v-for="(instance, index) in instances" :key="index">
        <component
          :is="instance.access_url ? 'a' : 'div'"
          :href="instance.access_url || undefined"
          class="mx-2 my-1 flex flex-row gap-2 p-2"
          :class="{ 'link': instance.access_url }">
          <div class="badge badge-primary">
            {{ instance.instance_type }}
          </div>
          <div class="overflow-hidden whitespace-nowrap">
            {{ instance.display_name }}
          </div>
        </component>
      </template>
    </div>
  </div>
</template>
<style>

</style>
