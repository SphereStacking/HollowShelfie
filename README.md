
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<img src="/.images/mamehinata.png" width="600" alt="mame">
</p>

<p align="center">
  <a href="https://forge.laravel.com/servers/785617/sites/2338620">
    <img src="https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F283c02c4-a46e-49f9-b8b0-d35d436be3e4%3Fdate%3D1%26commit%3D1&style=plastic" alt="SphereStacking" />
  </a>
</p>



## about

VR界隈の情報共有serviceの構築する。  
イベントやコミュニティの情報を一元的にまとめたい。  
まずは日々開催されているイベントの情報をより見やすくユーザーに届ける。  
結局は車輪の再発明だが。。

ユーザーがイベントを掲載できて
演者の募集や打診によるオーガナイザーのマッチング

## 目標

- イベント作成機能
  - 一覧表示
  - 詳細表示
  - 共有(外部SNS)
  - 検索
  - 編集
  - 削除
  - イベント情報の出演者の管理
  - 予約公開
  - タイムライン表示
  - custom id

- bookmark
- いいね
- タグ
- カテゴリ

- チーム機能
  - チーム作成
  - チーム編集
  - チーム削除
  - チームメンバーの管理
  - ロールの管理

- 出演者の募集
- 登録Userへのイベント出演依頼
- イベント管理機能

- qiitaやzennのような記事投稿機能

## 技術スタック

- [laravel](https://laravel.com/)
  - [sail](https://laravel.com/docs/10.x/sail) (爆速環境構築まん)
  - [jetstream](https://jetstream.laravel.com) (認証含めた神パッケージ)
  - [inertia](https://inertiajs.com/forms) (バックとフロントの密結合)
  - [scout](https://laravel.com/docs/10.x/scout) (全文検索)
  - [socialite](https://laravel.com/docs/10.x/socialite) (SNSログイン)
  - [cashier](https://laravel.com/docs/10.x/billing) (決済 その内いれたい。)
- [vue.js](https://vuejs.org/)
- [tailwindcss](https://tailwindcss.com/)
  - [daisyui](https://daisyui.com/)

- [tiptap](https://tiptap.dev) (WYSIWYGエディター)
- [meilisearch](https://www.meilisearch.com/) (全文検索)
  - 日本語の検索がいまいちなためimageはprototypeを使用
- [swiper](https://swiperjs.com/) (カルーセルバナー)
- [date-fns](https://date-fns.org/) (日付操作)  day.jsは削除予定
- [iconify](https://iconify.design/) (Iconに使用)


## 開発環境構築

1. git cloneして
2. .env.exampleをコピーして.envを作成
3. .envのDBの設定
   GOOGLEとDISCORDの<ここ必要>の個所を埋める。
   それぞれ個人で取得して設定してください  
   SNSログインができなくなるだけなので必要なければ設定不要。  

   ※MEILISEARCH　に関しては後ほどdocker imageをビルドしてから行う。

4. 依存ファイルのインストール
   1. `docker-compose up -d`
      ここで初回のインストールなりビルドが走ると思う。(多分)
   2. `docker-compose exec laravel.test bash`
   3. `npm i`
   4. `composer install`
   5. `exit`
   ここの手順あいまい。
   composerをPC自体にインストールして
   composer installしてたかも
5. `./vendor/bin/sail up`
   おこのみでsailのショートカットを作成してください
   `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`
6. メイリサーチセットアップ[notion参照](https://www.notion.so/ff35198dd447429ebaf3058b88d71034)
7. `docker-compose exec laravel.test bash`
8. `npm run dev`
    この段階ではログイン画面は表示されないと思う
9.  `php artisan migrate`
10. `php artisan db:seed`

## 構築後の起動

1. `sail up -d` sail環境の起動
2. `docker exec -it sphere_app-laravel.test-1  bash` で立ち上げた環境に入る。
3. `npm run dev` 開発サーバ起動



## gitの運用ワークフロー

- git-flow
- 初期リリースまではmainブランチからfeatureを切って作業
``` mermaid
gitGraph
   commit id: "Initial commit" tag: "v1.0"
   branch develop
   commit id: "Feature A"
   branch feature/featureA
   commit id: "Work on feature A"
   commit id: "Complete feature A"
   checkout develop
   merge feature/featureA
   commit id: "Feature B"
   branch feature/featureB
   commit id: "Work on feature B"
   commit id: "Complete feature B"
   checkout develop
   merge feature/featureB
   commit id: "Prepare release"
   branch release/v1.1
   commit id: "Release work"
   checkout main
   merge release/v1.1 tag: "v1.1"
   checkout develop
   merge release/v1.1
   commit id: "Hotfix"
   branch hotfix/v1.1.1
   commit id: "Fix critical bug"
   checkout main
   merge hotfix/v1.1.1 tag: "v1.1.1"
   checkout develop
   merge hotfix/v1.1.1
```

