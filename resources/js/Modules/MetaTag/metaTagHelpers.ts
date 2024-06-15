import { usePage } from '@inertiajs/vue3'
import DOMPurify from 'isomorphic-dompurify'

export type MetaTag = {
  content: string
} & (
  | { name: string; property?: never }
  | { property: string; name?: never }
)

/**
 * アプリ全体で共通に使用するMetaTagsを取得します。
 * @returns {MetaTag[]} MetaTagsを返します。
 */
export function GetAppMetaTags(): MetaTag[] {
  return [
    { property: 'og:type', content: 'website' },
    { property: 'og:title', content: DOMPurify.sanitize(usePage().props.title, { ALLOWED_TAGS: [] }) },
    { property: 'og:description', content: DOMPurify.sanitize(usePage().props.description, { ALLOWED_TAGS: [] }) },
    { property: 'og:site_name', content: DOMPurify.sanitize(usePage().props.config.appName, { ALLOWED_TAGS: [] }) },
    { property: 'og:image', content: `${usePage().props.ziggy.url}/storage/images/App/Logo.svg` },
  ]
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
