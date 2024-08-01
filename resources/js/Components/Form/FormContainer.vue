<script setup>
import { ref, computed, onMounted, nextTick} from 'vue'

const formStepContainerElement = ref(null)
const slots = useSlots()

const stepItems = computed(() => {
  return slots.default ? slots.default().map((vnode, index) => {
    const props = vnode.props || {}
    return {
      vnode,
      title: props['step-title'] || `Step ${index + 1}`,
      index
    }
  }) : []
})

const props = defineProps({
  topOffset: {
    type: Number,
    default: 0,
  },
  type: {
    type: String,
    default: 'single',
    validator: value => ['single', 'step'].includes(value),
  },
})

const currentStep = ref(0)
const lastStep = ref(0)
const hasErrorMessageId = ref(false)
const errorMessageId = ref('')
const errorComponentIndex = ref(-1)

const handleStepClick = (index) => {
  lastStep.value = currentStep.value
  currentStep.value = index
}

const prevStep = () => {
  handleStepClick(currentStep.value - 1)
  scrollToTop()
}

const nextStep = () => {
  handleStepClick(currentStep.value + 1)
  scrollToTop()
}

const scrollToTop = () => {
  const offset = props.topOffset
  const topPosition = formStepContainerElement.value.getBoundingClientRect().top + window.scrollY - offset
  window.scrollTo({ top: topPosition, behavior: 'smooth' })
}

const scrollToElement = (element) => {
  const offset = props.topOffset
  const topPosition = element.getBoundingClientRect().top + window.scrollY - offset
  window.scrollTo({ top: topPosition, behavior: 'smooth' })
}

const checkForErrorMessageId = (element) => {
  if (!element) return false
  if (element.id && element.id.startsWith('error-message-')) {
    scrollToElement(element)
    errorMessageId.value = element.id
    hasErrorMessageId.value = true
    return true
  }
  for (const child of element.children) {
    if (checkForErrorMessageId(child)) {
      return true
    }
  }
  hasErrorMessageId.value = false
  errorMessageId.value = ''
  return false
}

const findErrorComponentIndex = async () => {
  await nextTick()
  let found = false
  for (let i = 0; i < stepItems.value.length; i++) {
    const componentRoot = formStepContainerElement.value.querySelector(`[data-step-index="${i}"]`)
    if (componentRoot && checkForErrorMessageId(componentRoot)) {
      errorComponentIndex.value = i
      currentStep.value = i // エラーメッセージが見つかったステップに移動
      found = true
      break
    }
  }
  if (!found) {
    errorComponentIndex.value = -1
  }
}

const isSinglePage = computed(() => props.type === 'single')

onMounted(() => {
  findErrorComponentIndex()
})

defineExpose({ scrollToTop, checkForErrorMessageId, findErrorComponentIndex })

</script>

<template>
  <div ref="formStepContainerElement" class="flex flex-col gap-5">
    <ul class="steps steps-horizontal">
      <li
        v-for="(step, index) in stepItems"
        v-show="!isSinglePage"
        :key="index"
        class="custom-step step"
        :class="{ 'step-primary': currentStep >= index }"
        @click="handleStepClick(index)">
        {{ step.title }}
      </li>
    </ul>
    <div class="relative">
      <template v-for="(step, index) in stepItems" :key="index">
        <Transition
          class="duration-400 w-full"
          enter-active-class="absolute transition-all"
          leave-active-class="absolute transition-all"
          :enter-from-class="currentStep > lastStep ? 'opacity-0 -translate-x-6' : 'opacity-0 translate-x-6'"
          leave-to-class="opacity-0">
          <component
            :is="step.vnode"
            v-show="currentStep === index && !isSinglePage"
            :is-next="index < stepItems.length - 1"
            :is-prev="index > 0"
            :is-no-step="isSinglePage"
            :is-first="index === 0"
            :is-last="index === stepItems.length - 1"
            :prev-step="prevStep"
            :next-step="nextStep"
            :data-step-index="index" />
        </Transition>
        <Transition
          class="duration-400 w-full"
          enter-active-class="transition-all"
          leave-active-class="transition-all"
          enter-from-class="opacity-0 translate-y-6"
          leave-to-class="opacity-0">
          <component
            :is="step.vnode"
            v-show="isSinglePage"
            :is-next="index < stepItems.length - 1"
            :is-prev="index > 0"
            :is-no-step="isSinglePage"
            :is-first="index === 0"
            :is-last="index === stepItems.length - 1"
            :prev-step="prevStep"
            :next-step="nextStep"
            :data-step-index="index" />
        </Transition>
      </template>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.custom-step {
  @apply transition-all duration-200 ease-in-out;

  &::after {
    @apply transition-all duration-200 ease-in-out;
  }

  &:hover::after {
    @apply scale-125;
  }

  &:active::after {
    @apply scale-95 translate-y-0.5;
  }
}
</style>
