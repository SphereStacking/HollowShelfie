declare const window: Window & typeof globalThis & {
  open: (url?: string, target?: string, features?: string) => Window | null;
}

const SHARE_URL = 'https://misskey-hub.net/share/'

type MisskeyShareOptions = {
  url: string;
  text?: string;
  title?: string;
};

export const generateXShareUrl = ({ url, text, title }: MisskeyShareOptions): string => {
  const params = new URLSearchParams({
    text: text || '',
    title: title || '',
    url: url || '',
  })
  return `${SHARE_URL}?${params.toString()}`
}

export const shareOnMisskey = (options: MisskeyShareOptions): void => {
  const url = generateXShareUrl(options)
  window.open(url, '_blank')
}
