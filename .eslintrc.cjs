module.exports = {
  'env': {
    'browser': true,
    'es2021': true
  },
  'extends': [
    'eslint:recommended',
    'plugin:vue/vue3-recommended',
    'plugin:vue/vue3-essential',
    'plugin:tailwindcss/recommended',
    'plugin:@typescript-eslint/recommended',
  ],
  'overrides': [
    {
      'env': {
        'node': true
      },
      'files': [
        '.eslintrc.{js,cjs}'
      ],
    },
    {
    // Vueファイル用のoverridesを追加
      files: ['*.vue'],
      parser: 'vue-eslint-parser',
      parserOptions: {
        parser: '@typescript-eslint/parser',
      },
    },
  ],
  'parserOptions': {
    'ecmaVersion': 'latest',
    'sourceType': 'module',
  },
  'plugins': [
    'vue',
    '@typescript-eslint'
  ],
  globals: {
    'require': 'readonly',
    // Inertia
    'route': 'readonly',
    // Vue
    'ref': 'readonly',
    'reactive': 'readonly',
    'computed': 'readonly',
    'watch': 'readonly',
    'watchEffect': 'readonly',
    'toRefs': 'readonly',
    'toRef': 'readonly',
    'isRef': 'readonly',
    'unref': 'readonly',
    'nextTick': 'readonly',
    'onBeforeMount': 'readonly',
    'onMounted': 'readonly',
    'onBeforeUpdate': 'readonly',
    'onUpdated': 'readonly',
    'onBeforeUnmount': 'readonly',
    'onUnmounted': 'readonly',
    'defineComponent': 'readonly',
    'useSlots': 'readonly'
  },
  rules: {
    // jsとts併用のため設定
    '@typescript-eslint/no-var-requires': 'off',
    // タグの最後で改行しないで
    'vue/html-closing-bracket-newline': [2, { 'multiline': 'never' }],
    // 不要なカッコは消す
    'no-extra-parens': 1,
    // 無駄なスペースは削除
    'no-multi-spaces': 2,
    // 不要な空白行は削除。2行開けてたらエラー
    'no-multiple-empty-lines': [2, { 'max': 1 }],
    // 関数とカッコはあけない(function hoge() {/** */})
    'func-call-spacing': [2, 'never'],
    // true/falseを無駄に使うな
    'no-unneeded-ternary': 2,
    // セミコロンは禁止
    'semi': [2, 'never'],
    // 文字列はシングルクオートのみ
    'quotes': [2, 'single'],
    // varは禁止
    'no-var': 2,
    // jsのインデントは２
    'indent': [2, 2],
    // かっこの中はスペースなし！違和感
    'space-in-parens': [2, 'never'],
    // コンソールは許可
    'no-console': 0,
    // カンマの前後にスペース入れる？
    'comma-spacing': 2,
    // 配列のindexには空白入れるな(hogehoge[ x ])
    'computed-property-spacing': 2,
    // キー
    'key-spacing': 2,
    // キーワードの前後には適切なスペースを
    'keyword-spacing': 2,
    //一行あたりの属性の数
    'vue/max-attributes-per-line': ['error', {
      'singleline': {
        'max': 3
      },
      'multiline': {
        'max': 3
      }
    }],
    //タグのクローズ設定 <div></div> とか<myComponent />
    'vue/html-self-closing': ['error', {
      'html': {
        'void': 'never',
        'normal': 'never',
        'component': 'always'
      },
      'svg': 'always',
      'math': 'always'
    }],

    'tailwindcss/no-custom-classname': ['off', {
    }],
    //scriptタグを一番上に来るようにするルール
    'vue/component-tags-order': [
      'error',
      {
        order: ['script', 'template', 'style'],
      },
    ],
    'vue/multi-word-component-names': ['error', {
      'ignores': ['Index', 'Create', 'Edit', 'Show', 'Delete']
    }],
    'vue/html-indent': ['error', 2, {
      'attribute': 1,
      'baseIndent': 1,
      'closeBracket': 0,
      'alignAttributesVertically': true,
      'ignores': []
    }],
  },
}

