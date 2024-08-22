<script setup>
import { usePage, router } from '@inertiajs/vue3'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
import { debounce } from 'lodash'

const modalEventShare = ref(null)
const props = defineProps({
  events: {
    type: Array,
    required: true,
  },
  profileId: {
    type: String,
    required: true
  },
  profileType: {
    type: String,
    required: true
  },
  screenName: {
    type: String,
    required: true
  }
})

const filter = ref([])
const hasEvents = computed(() => {
  return props.events.data.length > 0
})

const debouncedRouterGet = debounce((newValue) => {
  router.get(
    route('profile.show', props.screenName),
    {
      filter: newValue
    },
    {
      preserveState: true,
      preserveScroll: true,
    })
}, 300)

watch(filter, (newValue, oldValue) => {
  const sortedNewValue = JSON.stringify([...newValue].sort())
  const sortedOldValue = JSON.stringify([...oldValue].sort())

  if (sortedNewValue !== sortedOldValue) {
    debouncedRouterGet(newValue)
  }
})

</script>
<template>
  <div v-if="hasEvents">
    <ModalEventShareConfirm ref="modalEventShare" />
    <div class="divider divider-end my-7 w-full text-2xl font-bold">
      <div>
        <IconTypeMapper type="event" />
      </div>
      <h4 class="font-bold">
        Events
        <BtnDropDownEventerFilter v-model="filter" class=" dropdown-end" />
      </h4>
    </div>
    <div class="my-2 grid w-full grid-cols-2 gap-2 sm:grid-cols-3  md:grid-cols-4 xl:grid-cols-6">
      <div v-for="(item, index) in props.events.data" :key="index" class="indicator size-full">
        <CardEventEventerlabel
          :event="item"
          :profile-type="props.profileType"
          :profile-id="props.profileId"
          scroll-region
          @share="modalEventShare.onBtnOpenModal(item)" />
      </div>
    </div>
  </div>
</template>
<style scoped>

</style>
