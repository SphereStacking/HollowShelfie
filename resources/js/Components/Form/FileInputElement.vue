<script setup>
import IconTypeMapper from '@/Components/IconTypeMapper.vue'
import { useForm } from '@inertiajs/vue3'

// import function to register Swiper custom elements
import { register } from 'swiper/element/bundle'
// register Swiper custom elements
register()

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
  help: {
    type: String,
    default: null
  },
  error: {
    type: String,
    default: null
  },
  warning: {
    type: String,
    default: null
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
  uploadRoute: {
    type: String,
    required: true
  },
  deleteRoute: {
    type: String,
    required: true
  }
})

// propsの値をバイト単位に変換
const maxFileSizeBytes = computed(() => convertSizeToBytes(props.maxFileSize))

const files = ref(props.modelValue || [])

const updateForm = useForm({
  _method: 'PUT',
  images: [],
})

const deleteForm = useForm({
  id: null,
})

const errorMessage = ref('')

const handleFileChange = (event) => {
  const uploadFiles = Array.from(event.target.files || event.dataTransfer.files)
  errorMessage.value = '' // エラーメッセージをリセット

  if (!validateIndividualSizes(uploadFiles)) {
    return // 個々のファイルサイズのチェックで失敗した場合、処理を中断
  }
  const filteredFiles = uploadFiles.filter(file => props.acceptedFileTypes.includes(file.type))
  if (filteredFiles.length <= 0){
    return
  }
  updateForm.images = filteredFiles
  updateForm.post(props.uploadRoute, {
    preserveScroll: true,
    onSuccess: (result) => {
      files.value.push(...result.props.response.files)
    },
    onError: () => {
      errorMessage.value = 'ファイルのアップロードに失敗しました。'
    }
  })
}

// 各ファイルのサイズが許可された最大値を超えていないか検証
function validateIndividualSizes(newFiles) {
  for (const file of newFiles) {
    if (file.size > maxFileSizeBytes.value) {
      errorMessage.value = ` "${file.name}" はサイズ(${props.maxFileSize})を超えています。`
      return false
    }
  }
  return true
}

const handleRemoveFile = (id) => {
  deleteForm.id = id
  deleteForm.delete(props.deleteRoute, {
    preserveScroll: true,
    onSuccess: () => {
      // 成功した場合、files 配列から該当するファイルを削除
      files.value = files.value.filter(file => file.id !== id)
    },
    onError: () => {},
  })
}
</script>

<template>
  <Wrapper
    :label="label" :help="help" :error="error"
    :warning="warning" :label-icon-type="labelIconType">
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
            <p class="mb-2 text-sm text-base-content">
              <span class="font-semibold">Click to upload</span> or drag and drop
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
      <div v-if="files.length > 0" class=" rounded-md bg-base-200 p-2">
        <SwiperWrapper
          v-model="files"
          :slides-per-view="3"
          :pagination="true"
          :loop="files.length > 1"
          :space-between="10">
          <template #item="{element, index}">
            <div class="relative mx-0.5">
              <button
                class="btn btn-circle btn-error btn-xs absolute right-0 top-0 m-1"
                @click="handleRemoveFile(element.id)">
                <IconTypeMapper type="delete" />
              </button>
              <FlyerImg
                :src="element.public_url" :alt="`File preview ${index}`"
                class="rounded-lg " />
            </div>
          </template>
        </SwiperWrapper>
      </div>
    </div>
  </Wrapper>
</template>

