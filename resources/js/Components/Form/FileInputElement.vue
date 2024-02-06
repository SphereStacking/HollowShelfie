<script setup>
import { ref, defineProps, defineEmits, watch, computed } from 'vue'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
import { Carousel, Slide, Navigation, Pagination } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

// 単位をバイトに変換する関数
const convertSizeToBytes = (size) => {
  if (typeof size === 'number') {
    return size // 数値の場合はそのまま返す
  }
  const units = {
    KB: 1024,
    MB: 1024 * 1024,
    GB: 1024 * 1024 * 1024
  }
  const match = size.match(/^(\d+(?:\.\d+)?)\s*(KB|MB|GB)$/i)
  if (match) {
    return parseFloat(match[1]) * units[match[2].toUpperCase()]
  }
  console.error('Invalid size format:', size)
  return 0
}

const props = defineProps({
  id: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  labelIconType: {
    type: String,
    required: true
  },
  modelValue: {
    type: Array,
    required: true
  },
  placeholder: {
    type: String,
    required: true
  },
  help: {
    type: String,
    required: true
  },
  error: {
    type: String,
    required: true
  },
  note: {
    type: String,
    default: 'Drag and drop! or Click to select!',
  },
  acceptedFileTypes: {
    type: Array,
    default: () => ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'] // Default allowed file types
  },
  maxFileSize: {
    type: [Number, String],
    default: '2MB' // デフォルト値を文字列で指定
  },
  maxTotalSize: {
    type: [Number, String],
    default: '10MB' // デフォルト値を文字列で指定
  },
})

// propsの値をバイト単位に変換
const maxFileSizeBytes = computed(() => convertSizeToBytes(props.maxFileSize))
const maxTotalSizeBytes = computed(() => convertSizeToBytes(props.maxTotalSize))

const myCarousel = ref(null)
const emit = defineEmits(['update:modelValue'])
const files = ref(props.modelValue || [])
const filePreviews = ref([])

const updateValue = () => {
  emit('update:modelValue', files.value)
}

watch(files, (newFiles, oldFiles) => {
  // Generate previews for newly added files
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

  // Remove previews for files that have been removed
  if (oldFiles.length > newFiles.length) {
    const removedFilesIndexes = oldFiles.map((oldFile, index) => newFiles.includes(oldFile) ? null : index).filter(index => index !== null)
    removedFilesIndexes.forEach(index => {
      filePreviews.value.splice(index, 1)
    })
  }
}, { deep: true })
const errorMessage = ref('')

const handleFileChange = (event) => {
  const newFiles = Array.from(event.target.files || event.dataTransfer.files)
  errorMessage.value = '' // エラーメッセージをリセット

  if (!validateTotalSize(newFiles)) {
    return // 合計サイズのチェックで失敗した場合、処理を中断
  }

  if (!validateIndividualSizes(newFiles)) {
    return // 個々のファイルサイズのチェックで失敗した場合、処理を中断
  }

  processFiles(newFiles) // ファイルサイズが適切な場合、ファイルを処理
}

// 選択されたファイルの合計サイズを検証
function validateTotalSize(newFiles) {
  const totalSize = newFiles.reduce((acc, file) => acc + file.size, files.value.reduce((acc, file) => acc + file.size, 0))
  if (totalSize > maxTotalSizeBytes.value) {
    errorMessage.value = `合計サイズが許可された最大値${(maxTotalSizeBytes.value / 1048576).toFixed(2)}MBを超えています。`
    return false
  }
  return true
}

// 各ファイルのサイズが許可された最大値を超えていないか検証
function validateIndividualSizes(newFiles) {
  for (const file of newFiles) {
    if (file.size > maxFileSizeBytes.value) {
      errorMessage.value = ` "${file.name}" は1ファイルに許可されたサイズを超えています。`
      return false
    }
  }
  return true
}

// ファイルを処理
function processFiles(validFiles) {
  const filteredFiles = validFiles.filter(file => props.acceptedFileTypes.includes(file.type))
  files.value = [...files.value, ...filteredFiles]
  updateValue()
}

const handleRemoveFile = (index) => {
  files.value.splice(index, 1)
  filePreviews.value.splice(index, 1)
  updateValue()
}
const itemsToShow = computed(() => {
  return filePreviews.value.length < 4 ? 4 : filePreviews.value.length
})
const acceptedFileTypesDisplay = computed(() => {
  return props.acceptedFileTypes.map(type => type.split('/')[1].toUpperCase()).join(', ')
})

const maxTotalSizeDisplay = computed(() => {
  let size = maxTotalSizeBytes.value
  const units = ['bytes', 'KB', 'MB', 'GB']
  let unitIndex = 0

  while (size >= 1024 && unitIndex < units.length - 1) {
    size /= 1024
    unitIndex++
  }

  // 小数点以下を丸める場合、toFixedを使用
  // ただし、小数点以下が0の場合は整数部のみを表示する
  const roundedSize = Math.round(size) === size ? Math.round(size) : size.toFixed(2)

  return `${roundedSize} ${units[unitIndex]}`
})

const totalFileSize = computed(() => {
  return files.value.reduce((total, file) => total + file.size, 0)
})
const progressValue = computed(() => {
  const totalSize = totalFileSize.value
  const maxSize = maxTotalSizeBytes.value
  if (maxSize === 0 || totalSize === 0) {
    return 0
  }
  const progress = totalSize / maxSize * 100
  return Math.min(progress, 100)
})
// 実際にテンプレートで表示する進捗値
const actualProgressValue = ref(0)

// progressValueの変更を監視し、actualProgressValueを徐々に増加させる
watch(progressValue, (newValue) => {
  const updateProgress = () => {
    const difference = newValue - actualProgressValue.value
    // 進捗値が増加する場合
    if (difference > 0) {
      actualProgressValue.value += Math.min(difference, 1) // 1ずつ増加
    }
    // 進捗値が減少する場合
    else if (difference < 0) {
      actualProgressValue.value += Math.max(difference, -1) // 1ずつ減少
    }
    if (actualProgressValue.value !== newValue) {
      requestAnimationFrame(updateProgress)
    }
  }
  requestAnimationFrame(updateProgress)
})
</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :label-icon-type="labelIconType">
    <div class="grid w-full grid-cols-1 gap-2">
      <div
        class="flex w-full items-center justify-center "
        @dragover.prevent
        @drop.prevent="handleFileChange">
        <label
          for="dropzone-file"
          class="input flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-md border-2 border-dashed">
          <div class="flex flex-col items-center justify-center pb-6 pt-5">
            <IconTypeMapper type="upload" class="text-5xl" />
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
              <span class="font-semibold">Click to upload</span> or drag and drop
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
              {{ acceptedFileTypesDisplay }} (MAX. {{ maxTotalSizeDisplay }})
            </p>
            <p>
              <progress class="progress progress-primary w-56" :value="actualProgressValue" max="100"></progress>
              {{ actualProgressValue.toFixed(2) }}%
            </p>
            <div v-if="errorMessage" class=" text-error">
              {{ errorMessage }}
            </div>
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
