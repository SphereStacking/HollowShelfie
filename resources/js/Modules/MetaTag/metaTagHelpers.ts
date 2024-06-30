import { usePage } from '@inertiajs/vue3'
import DOMPurify from 'isomorphic-dompurify'

export type MetaTag = {
  content: string
} & (
  | { name: string; property?: never }
  | { property: string; name?: never }
)

const title = 'VRChat イベントカレンダー | '
const description = 'VRChatのイベントの雰囲気がフライヤーから一目で分かる！イベント情報を日別・週別・月別・タグ・カテゴリ・主催者・演者など様々な条件で簡単に検索・共有できるサービス。'
const keywords = 'VRChat,Cluster,VR,イベント,カレンダー,バーチャルリアリティ,ソーシャルVR,イベントカレンダー,Event Calendar,メタバース,バーチャルイベント,オンラインイベント,VRコミュニティ,アバター,ワールド,バーチャルライブ'

/**
 * アプリ全体で共通に使用するMetaTagsを取得します。
 * @returns {MetaTag[]} MetaTagsを返します。
 */
export function GetAppMetaTags(): MetaTag[] {
  const appName = usePage().props.config.appName
  const url = usePage().props.ziggy.url
  return [
    { name: 'title', content: title + appName },
    { name: 'description', content: description },
    { name: 'keywords', content: keywords },
    { property: 'og:type', content: 'website' },
    { property: 'og:title', content: appName },
    { property: 'og:description', content: description },
    { property: 'og:site_name', content: appName },
    { property: 'og:image', content: `${url}/storage/images/ogp/summary_large_image.webp` },
    { property: 'twitter:card', content: 'summary_large_image' },
    { property: 'twitter:title', content: appName },
    { property: 'twitter:description', content: description },
    { property: 'twitter:image', content: `${url}/storage/images/ogp/summary_large_image.webp` },
  ]
}

export function GetAppJsonLd(): string {
  const appName = usePage().props.config.appName
  const url = usePage().props.ziggy.url

  return JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'WebSite',
    'name': title + appName,
    'url': url,
    'description': description,
    'potentialAction': {
      '@type': 'SearchAction',
      'target': `${url}/search?q={search_term_string}`,
      'query-input': 'required name=search_term_string'
    },
    'keywords': keywords
  })
}

/**
 * イベント詳細ページで使用するMetaTagsを取得します。
 * @returns {MetaTag[]} MetaTagsを返します。
 */
export function GetEventDetailMetaTags(): MetaTag[] {
  const eventMetaTags: MetaTag[] = [
    { property: 'og:url', content: DOMPurify.sanitize(usePage().props.ziggy.location, { ALLOWED_TAGS: [] }) },
    { property: 'og:type', content: 'article' },
    { property: 'og:title', content: DOMPurify.sanitize(usePage().props.event.title, { ALLOWED_TAGS: [] }) },
    { property: 'og:description', content: DOMPurify.sanitize(usePage().props.event.description, { ALLOWED_TAGS: [] }) },
    { property: 'og:site_name', content: DOMPurify.sanitize(usePage().props.config.appName, { ALLOWED_TAGS: [] }) },
    { property: 'article:published_time', content: DOMPurify.sanitize(usePage().props.event.start_date, { ALLOWED_TAGS: [] }) },
    { property: 'article:modified_time', content: DOMPurify.sanitize(usePage().props.event.end_date, { ALLOWED_TAGS: [] }) },
  ]
  usePage().props.event.files.map((file) => {
    eventMetaTags.push({ property: 'og:image', content: file.public_url })
  })
  usePage().props.event.category_names.map((category_name) => {
    eventMetaTags.push({ property: 'article:section', content: DOMPurify.sanitize(category_name, { ALLOWED_TAGS: [] }) })
  })
  usePage().props.event.tags.map((tag) => {
    eventMetaTags.push({ property: 'article:tag', content: DOMPurify.sanitize(tag, { ALLOWED_TAGS: [] }) })
  })
  return eventMetaTags
}

/**
 * プロフィール詳細ページで使用するMetaTagsを取得します。
 * @returns {MetaTag[]} MetaTagsを返します。
 */
export function GetProfileMetaTags(): MetaTag[] {
  const profileMetaTags: MetaTag[] = [
    { property: 'og:url', content: DOMPurify.sanitize(usePage().props.ziggy.location, { ALLOWED_TAGS: [] }) },
    { property: 'og:type', content: 'article' },
    { property: 'og:title', content: DOMPurify.sanitize(usePage().props.profile.detail.name, { ALLOWED_TAGS: [] }) },
    { property: 'og:description', content: DOMPurify.sanitize(usePage().props.profile.detail.bio, { ALLOWED_TAGS: [] }) },
    { property: 'og:site_name', content: DOMPurify.sanitize(usePage().props.config.appName, { ALLOWED_TAGS: [] }) },
    { property: 'og:image', content: DOMPurify.sanitize(usePage().props.profile.detail.photo_url, { ALLOWED_TAGS: [] }) },
  ]
  usePage().props.profile.detail.tags.map((tag) => {
    profileMetaTags.push({ property: 'article:tag', content: DOMPurify.sanitize(tag, { ALLOWED_TAGS: [] }) })
  })
  return profileMetaTags
}
