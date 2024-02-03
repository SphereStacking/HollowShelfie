<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
import { Carousel, Slide, Navigation, Pagination } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

const props = defineProps({
  id: String,
  label: {
    type: String,
    required: true
  },
  labelIconType: String,
  modelValue: Array,
  placeholder: String,
  help: String,
  error: String,
  note: {
    type: String,
    default: 'Drag and drop! or Click to select!',
  },
})

const myCarousel = ref(null)
const emit = defineEmits(['update:modelValue'])
const files = ref(props.modelValue || [])
const filePreviews = ref([])

const updateValue = () => {
  emit('update:modelValue', files.value)
}

watch(files, (newFiles, oldFiles) => {
  // 新しいファイルが追加された場合、そのプレビューを生成する
  const addedFiles = newFiles.filter(newFile => !oldFiles.some(oldFile => oldFile === newFile))
  addedFiles.forEach(file => {
    if (file.type.startsWith('image/')) {
      const reader = new FileReader()
      reader.onload = (e) => {
        filePreviews.value.push(e.target.result)
      }
      reader.readAsDataURL(file)
    }
  })

  // ファイルが取り除かれた場合、そのプレビューも取り除く
  if (oldFiles.length > newFiles.length) {
    const removedFilesIndexes = oldFiles.map((oldFile, index) => newFiles.includes(oldFile) ? null : index).filter(index => index !== null)
    removedFilesIndexes.forEach(index => {
      filePreviews.value.splice(index, 1)
    })
  }
}, { deep: true })
const isHover = ref(false)

const handleDragState = (state) => {
  isHover.value = state
}

const handleFileChange = (event) => {
  const newFiles = event.target.files || event.dataTransfer.files
  if (newFiles.length > 0) {
    files.value = [...files.value, ...Array.from(newFiles)]
    updateValue()
  }
  isHover.value = false
}

const handleRemoveFile = (index) => {
  files.value.splice(index, 1)
  filePreviews.value.splice(index, 1)
  updateValue()
}
const itemsToShow = computed(() => {
  return filePreviews.value.length < 4 ? 4 : filePreviews.value.length
})
</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :label-icon-type="labelIconType">
    <div class="grid w-full grid-cols-1 gap-2">
      <div
        class="flex w-full items-center justify-center "
        @dragenter="handleDragState(true)"
        @dragleave="handleDragState(false)"
        @dragover.prevent
        @drop.prevent="handleFileChange"
        @mouseover="handleDragState(true)"
        @mouseleave="handleDragState(false)">
        <label
          for="dropzone-file"
          class="input flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-md border-2 border-dashed">
          <div class="flex flex-col items-center justify-center pb-6 pt-5">
            <IconTypeMapper type="upload" class="text-5xl" />
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
              <span class="font-semibold">Click to upload</span> or drag and drop
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
              SVG, PNG, JPG or GIF (MAX. 800x400px)
            </p>
          </div>
          <input
            id="dropzone-file" type="file" class="hidden"
            name="file" multiple @change="handleFileChange">
        </label>
      </div>
      <Carousel
        ref="myCarousel"
        :items-to-show="itemsToShow" class="flex flex-col">
        <Slide v-for="(preview, index) in filePreviews" :key="preview">
          <div class="carousel__item relative mx-0.5">
            <button
              class="btn btn-circle btn-error btn-xs absolute right-0 top-0 m-1"
              @click="handleRemoveFile(index)">
              <IconTypeMapper type="delete" />
            </button>
            <img
              :src="preview" :alt="`File preview ${index}`"
              class=" rounded-lg object-cover">
          </div>
        </Slide>
      </Carousel>
    </div>
  </Wrapper>
</template>

<style lang="">
</style>
