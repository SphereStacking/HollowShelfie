import { usePage } from '@inertiajs/vue3'
import DOMPurify from 'isomorphic-dompurify'

export function GetAppMetaTags() {
  return [
    { property: 'og:type', content: 'website' },
    { property: 'og:title', content: DOMPurify.sanitize(usePage().props.title, { ALLOWED_TAGS: [] }) },
    { property: 'og:description', content: DOMPurify.sanitize(usePage().props.description, { ALLOWED_TAGS: [] }) },
    { property: 'og:site_name', content: DOMPurify.sanitize(usePage().props.config.appName, { ALLOWED_TAGS: [] }) },
    { property: 'og:image', content: `${usePage().props.ziggy.url}/storage/images/App/Logo.svg` },
  ]
}

export function GetEventDetailMetaTags() {
  const eventMetaTags = [
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
