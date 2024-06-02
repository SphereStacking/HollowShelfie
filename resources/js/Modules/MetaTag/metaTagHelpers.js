import { usePage } from '@inertiajs/vue3'

export function GetAppMetaTags() {
  return [
    { property: 'og:type', content: 'website' },
    { property: 'og:title', content: usePage().props.title },
    { property: 'og:description', content: usePage().props.description },
    { property: 'og:site_name', content: usePage().props.config.appName },
    { property: 'og:image', content: usePage().props.ziggy.url +'/storage/images/App/Logo.svg' },
  ]
}

export function GetEventDetailMetaTags() {
  const eventMetaTags = [
    { property: 'og:url', content: usePage().props.ziggy.location },
    { property: 'og:type', content: 'article' },
    { property: 'og:title', content: usePage().props.event.title },
    { property: 'og:description', content: usePage().props.event.description },
    { property: 'og:site_name', content: usePage().props.config.appName },
    { property: 'article:published_time', content: usePage().props.event.start_date },
    { property: 'article:modified_time', content: usePage().props.event.end_date },
  ]
  usePage().props.event.files.map((file) => {
    eventMetaTags.push({ property: 'og:image', content: file.public_url })
  })
  usePage().props.event.category_names.map((category_name) => {
    eventMetaTags.push({ property: 'article:section', content: category_name })
  })
  usePage().props.event.tags.map((tag) => {
    eventMetaTags.push({ property: 'article:tag', content: tag })
  })
  return eventMetaTags
}
