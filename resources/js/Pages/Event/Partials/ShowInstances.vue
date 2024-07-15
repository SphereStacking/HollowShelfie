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
    <div class="flex w-full flex-col  rounded-xl bg-base-200">
      <template v-for="(instance, index) in instances" :key="index">
        <div
          class="indicator mr-2 flex w-full flex-row items-center gap-2 p-2">
          <span class="badge indicator-item badge-primary badge-xs right-5"> {{ instance.instance_type }}</span>
          <component
            :is="instance.access_url ? 'a' : 'p'"
            :href="instance.access_url || undefined"
            class="mt-1 break-all text-left text-xs"

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
