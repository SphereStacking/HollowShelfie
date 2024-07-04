declare const window: Window & typeof globalThis & {
  open: (url?: string, target?: string, features?: string) => Window | null;
}
const SHARE_URL = 'https://x.com/intent/post'

type XShareOptions = {
  url: string;
  text?: string;
  hashtags?: string[];
  via?: string;
};

export const generateXShareUrl = ({ url, text, hashtags, via }: XShareOptions): string => {
  const params = new URLSearchParams({
    text: text || '',
    hashtags: hashtags?.join(',') || '',
    via: via || '',
    url: url || '',
  })
  return `${SHARE_URL}?${params.toString()}`
}

export const shareOnX = (options: XShareOptions): void => {
  const url = generateXShareUrl(options)
  window.open(url, '_blank')
}
