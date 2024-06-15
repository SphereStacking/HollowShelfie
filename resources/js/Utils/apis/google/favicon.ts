const GOOGLE_FAVICON_URL = 'https://www.google.com/s2/favicons?domain='

export const getFaviconUrl = (url: string): string => {
  return `${GOOGLE_FAVICON_URL}${new URL(url).hostname}`
}
