
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
VR界隈([vrchat](https://vrchat.com/home), [cluster](https://cluster.mu/), [resonite](https://resonite.com/))の情報共有serviceの構築する。  
現在のVR界隈は情報のまとまっているところがない  
イベントやコミュニティの情報を一元的にまとめることで活性化を図りたい。  
まずは日々開催されているイベントの情報をより見やすくユーザーに届ける。  

## 結局は車輪の再発明だが。。

- [vrchatイベントカレンダー](https://vrceve.com/)
  - グーグルカレンダーベースのイベント情報掲載サイト
- [vrcタイムライン](https://vrc.tl/)
  - 海外Userのタイムライン形式のイベント情報掲載サイト
- [twipla](https://twipla.jp/)
  - 有名どころのイベント共有
- [connpass](https://connpass.com)
  - 有名どころのイベント共有
- [PlanetVRC](https://planetvrchat.net/)
  - 特定ユーザーによるVR界隈記事投稿
- [メタカル最前線](https://metacul-frontier.com/)
  - 特定ユーザーによるR界隈記事投稿
- Qiita Note Zennなど
  - ユーザーにようる記事投稿


このwebサービスの目指すところは上記サイトのいいとこどりを目指す。

ユーザーがイベントを掲載できて
演者の募集や打診によるオーガナイザーのマッチング
記事投稿もできてVR界隈のナレッジの共有ができる(かなりニッチで技術に疎い人はアバターアップロードや改変すらままならないため)

ドメインは  v-shelf.com

イベントのfryerやチラシを掲示する棚をイメージしてこの名称

## その他
- [github PJ](https://github.com/orgs/ShakeSpheres/projects/1)
- [slack](https://join.slack.com/t/shake-spheres/shared_invite/zt-2asmw8mhg-nAHGk4Ub88NzvyKveZDcAg)
- [notion](https://www.notion.so/invite/b9dcd6b1ec909bf0c03498f20b2ede15fa2c3c59)

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

最終的にはチケットを販売できるようになると嬉しいかも。

## 課題

- インフラ全く分からん。

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
- [vue3-carousel](https://ismail9k.github.io/vue3-carousel/) (カルーセルバナー)
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
   3. `composer install`
   4. `exit`
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

## links

OAuth2.0用
- [Google Cloud Console](https://console.cloud.google.com/welcome?authuser=1&hl=ja&project=pj-sphere)
- [Discord Developer](https://discord.com/developers/applications/1172881212809936916/information)

