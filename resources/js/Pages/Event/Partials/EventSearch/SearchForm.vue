<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue'
import { usePage } from '@inertiajs/vue3'
import ConditionDate from './ConditionDate.vue'
import ConditionCategory from './ConditionCategory.vue'
import ConditionTag from './ConditionTag.vue'
import ConditionOrganizer from './ConditionOrganizer.vue'
import ConditionPerformer from './ConditionPerformer.vue'
import ConditionOther from './ConditionOther.vue'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
import FilterItemDate from './FilterItemDate.vue'
import FilterItemCategory from './FilterItemCategory.vue'
import FilterItemTag from './FilterItemTag.vue'
import FilterItemOrganizer from './FilterItemOrganizer.vue'
import FilterItemPerformer from './FilterItemPerformer.vue'
import FilterItemInstance from './FilterItemInstance.vue'
import FilterItemStatus from './FilterItemStatus.vue'

const props = defineProps({
  text: {
    type: String,
    required: true,
  },
  modelValue: {
    type: Object,
    required: true,
    default: () => ({})
  },
  categories: {
    type: Array,
    required: true
  },
  tags: {
    type: Array,
    required: true
  },
  performers: {
    type: Array,
    required: true
  },
  organizers: {
    type: Array,
    required: true
  },
  statuses: {
    type: Object,
    required: true
  },
  instanceTypes: {
    type: Array,
    required: true
  },
})
const emit = defineEmits([
  'update:modelValue',
  'update:text',
  'executeSearch',
])

const info = ref()
const infoOpenModal = () => { info.value.onBtnOpenModal() }

const queryParams = ref({})
const conditions = ref(props.modelValue)
const text = ref(props.text)
const history = ref([]) // Added this line
const currentPosition = ref(-1) // Added this line
const categories = ref(props.categories ? props.categories.map(v => v.name) : [])
const selectFilterType = ref('other')
const isOpenFilter = ref(false)

const includesOrder = ['and', 'or', 'not']

const filterMaps = [
  { type: 'other', label: 'other', component: ConditionOther, items: { 'statuses': props.statuses, 'instanceTypes': props.instanceTypes } },
  { type: 'category', label: 'category', component: ConditionCategory, items: categories },
  { type: 'tag', label: 'tags', component: ConditionTag, items: props.tags },
  { type: 'date', label: 'date', component: ConditionDate, items: [] },
  { type: 'organizer', label: 'organizer', component: ConditionOrganizer, items: props.organizers },
  { type: 'performer', label: 'performer', component: ConditionPerformer, items: props.performers },
]

const filterItemMap={
  status: FilterItemStatus,
  category: FilterItemCategory,
  date: FilterItemDate,
  organizer: FilterItemOrganizer,
  performer: FilterItemPerformer,
  tag: FilterItemTag,
  instance: FilterItemInstance,
}

const includeLabels = {
  'and': { label: 'かつ', tooltip: 'すべての条件を満たすものを検索', icon: 'intersect' },
  'or': { label: 'または', tooltip: 'いずれかの条件を満たすものを検索', icon: 'union' },
  'not': { label: '除く', tooltip: '指定した条件を除外して検索', icon: 'exclude' },
}
const cycleSearchCondition = (index) => {
  const item = { ...conditions.value[index] } // Create a new object
  const currentIncludeIndex = includesOrder.indexOf(item.include)
  const nextIncludeIndex = (currentIncludeIndex + 1) % includesOrder.length
  item.include = includesOrder[nextIncludeIndex]
  conditions.value[index] = item // Assign the new object
  pushToHistory()
}

const pushToHistory = () => {
  history.value = history.value.slice(0, currentPosition.value + 1)
  history.value.push([...conditions.value])
  currentPosition.value++

  console.log(history.value)
}

const addCondition = ({ type, value, include = includesOrder[0] }) => {
  if (value == '') { return }
  const itemExists = conditions.value.some(item => item.type === type && item.value === value)
  if (!itemExists) {
    conditions.value.push({ include, type, value })
  }
  pushToHistory()
}
const removeCondition = (index) => {
  conditions.value = conditions.value.filter((_, i) => i !== index)
  pushToHistory()
}

const clearConditions = () => {
  conditions.value = []
  pushToHistory()
}
const canCleared = () => conditions.value.length !== 0
const isSameCondition = computed(() => JSON.stringify(conditions.value) === JSON.stringify(queryParams.value.q))
const hasSearchConditions = computed(() => conditions.value && conditions.value.length > 0 && isSameCondition)
const emitExecuteSearch = () => { emit('executeSearch') }
const canGoBackInHistory = () => currentPosition.value > 0
const canGoForwardInHistory = () => currentPosition.value < history.value.length - 1

const goForwardInHistory = () => {
  if (currentPosition.value < history.value.length - 1) {
    currentPosition.value++
    conditions.value = [...history.value[currentPosition.value]]
  }
}

const goBackInHistory = () => {
  if (currentPosition.value > 0) {
    currentPosition.value--
    console.log(history.value[currentPosition.value])
    conditions.value = [...history.value[currentPosition.value]]
  }
}

watch(text, () => {
  emit('update:text', text.value)
}, { deep: true })

watch(conditions, () => {
  emit('update:modelValue', conditions.value)
}, { deep: true })

onMounted(() => {
  queryParams.value = usePage().props.ziggy.query
  if (queryParams.value.q) {
    queryParams.value.q.forEach(condition => {
      addCondition({
        type: condition.type,
        value: condition.value,
        include: condition.include,
      })
    })
    isOpenFilter.value = true
  }
  if (queryParams.value.t) {
    text.value = queryParams.value.t
  }
  pushToHistory()
})

</script>
<template>
  <div class="">
    <div class="collapse overflow-visible bg-base-100">
      <input v-model="isOpenFilter" type="checkbox">
      <div class="collapse-title pl-1 pr-0 text-xl font-medium">
        <div class="flex flex-row items-center gap-2 text-xl font-medium ">
          <div class="join w-full">
              <IconTypeMapper type="search" class="mx-2 text-xl" />
            </button>
          </div>
          <BtnSwapOpenFilter
            v-model:check="isOpenFilter" class="btn indicator btn-sm w-16"
            swap-effect="rotate" on-color="text-neutral-content" off-color="text-neutral-content">
            <div v-if="hasSearchConditions" class="badge indicator-item badge-info" @click="emitExecuteSearch()">
              <IconTypeMapper :type="isSameCondition ? 'check' : 'uploading'" class=" text-sm " />
            </div>
          </BtnSwapOpenFilter>
        </div>
      </div>

      <div class="collapse-content px-1">
        <!-- 表示エリア start -->
        <div class="flex flex-row items-center gap-1">
          filters
          <IconTypeMapper type="info" class="text-xl text-accent" @click="infoOpenModal" />
        </div>
        <div v-if="isOpenFilter" class="flex h-auto min-h-[2.7rem] w-full flex-wrap gap-2 rounded-md border-2 p-2">
          <div
            v-for="( item, index ) in conditions" :key="index"
            class="flex flex-row items-center">
            <button class="btn btn-ghost btn-xs p-0">
              <IconTypeMapper :type="includeLabels[item.include].icon" class="text-xl" @click="cycleSearchCondition(index)" />
            </button>
            <span class="mx-0.5">:</span>
            <component :is="filterItemMap[item.type]" :value="item.value" @click="removeCondition(index)" />
          </div>
        </div>

        <!-- セレクトエリア start -->
        <div class="mt-2 grid grid-cols-1 gap-4 rounded-md bg-base-300 p-4 md:grid-cols-4">
          <div class="menu grid w-full grid-cols-3 gap-2 rounded-box bg-base-200 md:grid-cols-1">
            <button
              v-for=" item in filterMaps" :key="item.type" class="btn btn-sm justify-start md:btn-md"
              :class="{ 'btn-accent': selectFilterType.type == item.type }"
              @click="selectFilterType = item">
              <IconTypeMapper :type="item.type" />
              {{ item.label }}
            </button>
          </div>
          <div class="col-span-1 flex flex-col gap-2 md:col-span-3">
            <div class="flex flex-wrap justify-end gap-2">
              <button
                class="btn btn-accent btn-xs" :class="{ 'btn-disabled': !canGoBackInHistory() }"
                @click="goBackInHistory">
                <IconTypeMapper type="arrowLeft" class="text-xl" />
              </button>
              <button
                class="btn btn-accent btn-xs" :class="{ 'btn-disabled': !canGoForwardInHistory() }"
                @click="goForwardInHistory">
                <IconTypeMapper type="arrowRight" class="text-xl" />
              </button>
              <button class=" btn btn-accent btn-xs" :class="{ 'btn-disabled': !canCleared() }" @click="clearConditions">
                <IconTypeMapper type="trashBox" class="text-xl" />
              </button>
            </div>
            <div v-if="isOpenFilter" class="size-full rounded-xl  border-2 p-4">
              <component
                :is="selectFilterType.component"
                :items="selectFilterType.items"
                :add-condition-func="addCondition" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <ModalSerchInfo ref="info" />
  </div>
</template>

<style scoped>

</style>
