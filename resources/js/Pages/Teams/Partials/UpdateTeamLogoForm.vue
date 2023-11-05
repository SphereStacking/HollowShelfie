<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { defineProps } from '@vue/runtime-core';

// コンポーネントのインポート
import FormSection from '@/Jetstream/FormSection.vue';

// プロパティの定義
const props = defineProps({
  team: Object,
});

// フォームデータの初期化
const form = useForm({
  _method: 'PUT',
  logo: null,
});

// リアクティブな変数の定義
const logoPreview = ref(null);
const logoInput = ref(null);

// ロゴのプレビューを更新する関数
const updateLogoPreview = () => {
  const file = logoInput.value.files[0];
  if (!file) return;

  const reader = new FileReader();

  reader.onload = e => {
    logoPreview.value = e.target.result;
  };
  reader.onerror = e => {
    console.error('ファイルの読み込みに失敗しました:', e);
  };

  reader.readAsDataURL(file);
};

// 新しいロゴを選択する関数
const selectNewLogo = () => {
  logoInput.value.click();
};

// ロゴ情報を更新する関数
const updateLogoInformation = () => {
  form.logo = logoInput.value.files[0];
  form.post(route('current-team-logo.update', props.team.id), {
    preserveScroll: true,
    onSuccess: clearLogoFileInput,
  });
};

// ロゴのファイル入力をクリアする関数
const clearLogoFileInput = () => {
  if (logoInput.value) {
    logoInput.value.value = null;
  }
};

// ロゴを削除する関数
const deleteLogo = () => {
  form.delete(route('current-team-logo.destroy', props.team.id), {
    preserveScroll: true,
    onSuccess: () => {
      logoPreview.value = null;
      clearLogoFileInput();
    },
  });
};
</script>

<template>
  <FormSection @submitted="updateLogoInformation">
    <template #title>
      Logo
    </template>

    <template #description>
      チームのロゴを更新します。
    </template>

    <template #form>
      <!-- ロゴ入力エリア -->
      <div class="col-span-6 sm:col-span-4">
        <!-- ロゴファイルの隠し入力 -->
        <input ref="logoInput" type="file" class="hidden" @change="updateLogoPreview">

        <!-- 現在のロゴ -->
        <div v-if="!logoPreview" class="mt-2">
          <img :src="team.team_logo_url" :alt="team.name" class="object-cover">
        </div>

        <!-- 新しいロゴのプレビュー -->
        <div v-if="logoPreview" class="mt-2">
          <img :src="logoPreview" alt="New logo preview" class="object-cover">
        </div>

        <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewLogo">
          新しいロゴを選択
        </SecondaryButton>

        <SecondaryButton v-if="team.team_logo_path" type="button" class="mt-2" @click.prevent="deleteLogo">
          ロゴを削除
        </SecondaryButton>

        <!-- ロゴエラー表示 -->
        <InputError :message="form.errors.logo" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <!-- アクションメッセージ -->
      <ActionMessage :on="form.recentlySuccessful" class="mr-3">
        保存しました。
      </ActionMessage>

      <!-- 保存ボタン -->
      <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        保存
      </PrimaryButton>
    </template>
  </FormSection>
</template>

