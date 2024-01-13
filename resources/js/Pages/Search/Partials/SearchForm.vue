<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue'
import { usePage } from '@inertiajs/vue3'

import dayjs from 'dayjs'

const props = defineProps({
  text: {
    type: String,
    required: true,
  },
  modelValue: {
    type: Object,
    required: true,
    default: () => []
  },
  categories: {
    type: Array,
    required: true
  },
  tags: {
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
  'update:text'
])

const info = ref()
const infoOpenModal = () => { info.value.onBtnOpenModal() }

const queryParams = ref({})
const conditions = ref(props.modelValue)
const text = ref(props.text)
const history = ref([]) // Added this line
const currentPosition = ref(-1) // Added this line
const categories = ref(props.categories.map(v => v.name))
const tags = ref(props.tags.map(v => v))
const selectFilterType = ref('')
const isOpenFilter = ref(false)
const searchCategoryText = ref('')
const searchTagText = ref('')
const searchDateText = ref('')
const searchTitleText = ref('')
const searchUserText = ref('')

const includesOrder = ['and', 'or', 'not']

const inputRefs = {
  'category': searchCategoryText,
  'tag': searchTagText,
  'title': searchTitleText,
  'user': searchUserText
}

const filterMaps = [
  { type: 'category', label: 'category' },
  { type: 'date', label: 'date' },
  { type: 'status', label: 'status' },
  { type: 'tag', label: 'tags' },
  { type: 'other', label: 'other' }
]

const includeLabels = {
  'and': { label: 'かつ', tooltip: 'すべての条件を満たすものを検索', icon: 'fluent:shape-intersect-24-filled' },
  'or': { label: 'または', tooltip: 'いずれかの条件を満たすものを検索', icon: 'fluent:shape-union-20-filled' },
  'not': { label: '除く', tooltip: '指定した条件を除外して検索', icon: 'fluent:shape-exclude-20-filled' },
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
  const prefix = Object.keys(includeLabels).find(key => value.startsWith(key + ':'))
  include = prefix || include
  if (prefix) {
    value = value.slice(prefix.length + 1).trim().toLowerCase()
  }
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
        <div class="felx-row flex items-center gap-2 text-xl font-medium ">
          <div class="join w-full">
            <input v-model="text" type="text" class="input join-item input-bordered input-sm w-full">
            <button class="btn btn-outline join-item btn-sm" @click="emitExecuteSearch()">
              <Icon icon="mdi:magnify" class="mx-2 text-xl" />
            </button>
          </div>
          <button class="btn indicator btn-neutral btn-sm w-16" @click="isOpenFilter = !isOpenFilter">
            <Icon icon="mdi:tune" class="text-xl" />
            <div v-if="hasSearchConditions" class="badge indicator-item badge-info" @click="emitExecuteSearch()">
              <Icon :icon="isSameCondition ? 'mdi:check' : 'line-md:uploading-loop'" class=" text-sm " />
            </div>
          </button>
        </div>
      </div>

      <div class="collapse-content px-1">
        <!-- 表示エリア start -->
        <div class="flex flex-row items-center gap-1">
          filters
          <Icon icon="mdi:information-slab-circle" class="text-xl text-accent" @click="infoOpenModal" />
        </div>
        <div class="flex h-auto min-h-[2.7rem] w-full flex-wrap gap-2 rounded-md border-2 p-2">
          <div v-for="( item, index ) in conditions " v-if="isOpenFilter" class="flex flex-row items-center">
            <button class="btn btn-ghost btn-xs p-0">
              <Icon :icon="includeLabels[item.include].icon" class="text-xl" @click="cycleSearchCondition(index)" />
            </button>
            <span class="mx-0.5">:</span>
            <BtnEventSerchItem
              :key="index" :type="item.type" :value="item.value"
              is-close is-icon
              @remove="removeCondition(index)" />
          </div>
        </div>

        <!-- セレクトエリア start -->
        <div class="mt-2 grid grid-cols-4 gap-4 rounded-md bg-base-300  p-4">
          <div class="col-span-1 flex flex-col gap-2">
            <div class="menu w-full  rounded-box bg-base-200">
              <button
                v-for=" item in filterMaps " class="btn justify-start"
                :class="{ 'btn-primary': selectFilterType == item.type }" @click="selectFilterType = item.type">
                <IconTypeMapper :type="item.type" />
                {{ item.label }}
              </button>
            </div>
          </div>
          <div class="col-span-3 flex flex-col gap-2 ">
            <div class="flex flex-wrap justify-end gap-2">
              <button
                class="btn btn-accent btn-xs" :class="{ 'btn-disabled': !canGoBackInHistory() }"
                @click="goBackInHistory">
                <Icon icon="mdi:chevron-left" class="text-xl" />
              </button>
              <button
                class="btn btn-accent btn-xs" :class="{ 'btn-disabled': !canGoForwardInHistory() }"
                @click="goForwardInHistory">
                <Icon icon="mdi:chevron-right" class="text-xl" />
              </button>
              <button class=" btn btn-accent btn-xs" :class="{ 'btn-disabled': !canCleared() }" @click="clearConditions">
                <Icon icon="mdi:delete-empty-outline" class="text-xl" />
              </button>
            </div>
            <div v-if="isOpenFilter" class="h-full w-full  rounded-xl border-2 p-4">
              <TransitionSlideUp :is-show="selectFilterType == 'date'">
                <div class="flex flex-wrap gap-2">
                  <div class="join w-full">
                    <PickerDateRange
                      v-model="searchDateText" class="join-item "
                      input-classes="input input-sm input-bordered z-20" />
                    <button
                      class="felx-row btn join-item btn-neutral btn-sm flex gap-2 "
                      @click="addCondition({ type: 'date', value: searchDateText })">
                      Add
                    </button>
                  </div>
                  <BtnEventSerchItem
                    type="date" value="今日"
                    @click="addCondition({ type: 'date', value: dayjs().format('YYYY-MM-DD') })" />
                  <BtnEventSerchItem
                    type="date" value="今週"
                    @click="addCondition({ type: 'date', value: dayjs().startOf('week').format('YYYY-MM-DD') + ' ~ ' + dayjs().endOf('week').format('YYYY-MM-DD') })" />
                  <BtnEventSerchItem
                    type="date" value="今月"
                    @click="addCondition({ type: 'date', value: dayjs().startOf('month').format('YYYY-MM-DD') + ' ~ ' + dayjs().endOf('month').format('YYYY-MM-DD') })" />
                </div>
              </TransitionSlideUp>
              <TransitionSlideUp :is-show="selectFilterType == 'status'">
                <div class="flex gap-1">
                  <BtnEventSerchItem
                    v-for="( status, label ) in statuses " :key="status" type="status"
                    :value="status"
                    @click="addCondition({ type: 'status', value: status })" />
                </div>
              </TransitionSlideUp>
              <TransitionSlideUp :is-show="selectFilterType == 'category'">
                <div class="flex flex-wrap gap-2">
                  <div class="join w-full">
                    <input
                      v-model="searchCategoryText" type="text" class="input join-item input-bordered input-sm w-full"
                      @keyup.enter="addCondition({ type: 'category', value: searchCategoryText })">
                    <button
                      class="felx-row btn join-item btn-neutral btn-sm flex gap-2"
                      @click="addCondition({ type: 'category', value: searchCategoryText })">
                      Add
                    </button>
                  </div>
                  <BtnEventSerchItem
                    v-for=" category in categories " :key="category" type="category"
                    :value="category"
                    @click="addCondition({ type: 'category', value: category })" />
                </div>
              </TransitionSlideUp>
              <TransitionSlideUp :is-show="selectFilterType == 'tag'">
                <div class="flex flex-wrap gap-2">
                  <div class="join w-full">
                    <input
                      v-model="searchTagText" type="text" class="input join-item input-bordered input-sm w-full"
                      @keyup.enter="addCondition({ type: 'tag', value: searchTagText })">
                    <button
                      class="felx-row btn join-item btn-neutral btn-sm flex gap-2"
                      @click="addCondition({ type: 'tag', value: searchTagText })">
                      Add
                    </button>
                  </div>
                  <BtnEventSerchItem
                    v-for=" tag in tags " :key="tag" type="tag"
                    :value="tag"
                    @click="addCondition({ type: 'tag', value: tag })" />
                </div>
              </TransitionSlideUp>
              <TransitionSlideUp :is-show="selectFilterType == 'other'">
                <div class="flex flex-col gap-1">
                  <div class="flex flex-row gap-1">
                    <IconTypeMapper type="instance" class="text-xl" />
                    instance
                  </div>
                  <div class="flex gap-1">
                    <BtnEventSerchItem
                      v-for=" instanceType in instanceTypes " :key="instanceType" type="location"
                      :value="instanceType" @click="addCondition({ type: 'instance', value: instanceType })" />
                  </div>
                  <div class="flex flex-row gap-1">
                    <IconTypeMapper type="user" class="text-xl" />
                    user
                  </div>
                  <div class="join w-full">
                    <input
                      v-model="searchUserText" type="text" class="input join-item input-bordered input-sm w-full"
                      @keyup.enter="addCondition({ type: 'user', value: searchUserText })">
                    <button
                      class="felx-row btn join-item btn-neutral btn-sm flex gap-2"
                      @click="addCondition({ type: 'user', value: searchUserText })">
                      Add
                    </button>
                  </div>
                  <div class="flex flex-row gap-1">
                    <IconTypeMapper type="more" class="text-xl" />
                    more
                  </div>
                  <div class="flex gap-1">
                    <BtnEventSerchItem
                      v-for=" instanceType in instanceTypes " :key="instanceType" type="location"
                      :value="instanceType" @click="addCondition({ type: 'instance', value: instanceType })" />
                  </div>
                </div>
              </TransitionSlideUp>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ModalSerchInfo ref="info" />
  </div>
</template>

