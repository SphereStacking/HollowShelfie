/**
 * SNSまたはカレンダーにシェアまたはイベント追加する関数
 * @param {string} platform シェアするプラットフォームまたはカレンダー
 * @param {Object} options シェアまたはイベント追加のオプション
 *  - text: シェアするテキスト
 *  - url: シェアするURL
 *  - hashtags: Twitterで使用するハッシュタグ
 *  - mention: Twitterでメンションするユーザー名
 *  - instance: MastodonやMisskeyで使用するインスタンスのURL
 */
export function shareToSNS(platform, options) {
  // シェアURLを生成
  const shareUrl = generateShareUrl(platform, options)

  // 未対応のプラットフォームの場合はエラーを出力
  if (!shareUrl) {
    console.error('未対応のプラットフォームです')
    return
  }

  // 新しいウィンドウでシェアURLを開く
  window.open(shareUrl, '_blank')
}

// シェアURLを生成するヘルパー関数
const generateShareUrl = (platform, options) => {
  console.log(options)
  switch (platform) {
  case 'twitter':
    return generateTwitterUrl(options)
  case 'facebook':
    return generateFacebookUrl(options)
  case 'linkedin':
    return generateLinkedInUrl(options)
  case 'reddit':
    return generateRedditUrl(options)
  case 'whatsapp':
    return generateWhatsAppUrl(options)
  case 'email':
    return generateEmailUrl(options)
  case 'mastodon':
  case 'misskey':
    return generateMastodonMisskeyUrl(options)
  default:
    return ''
  }
}

// Twitter用のURLを生成
// 使用するオプション: text, url, hashtags, mention
const generateTwitterUrl = ({ text, hashtags }) => {
  let twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}`
  // ハッシュタグの配列を処理
  if (Array.isArray(hashtags)) {
    const formattedHashtags = hashtags.map(tag => tag.startsWith('#') ? tag : `#${tag}`).join(' ')
    twitterUrl += `&hashtags=${encodeURIComponent(formattedHashtags)}`
  }
  return twitterUrl
}

// Facebook用のURLを生成
// 使用するオプション: url
const generateFacebookUrl = ({ url }) => {
  return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`
}

// LinkedIn用のURLを生成
// 使用するオプション: url
const generateLinkedInUrl = ({ url }) => {
  return `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`
}

// Reddit用のURLを生成
// 使用するオプション: text, url
const generateRedditUrl = ({ text, url }) => {
  return `https://www.reddit.com/submit?url=${encodeURIComponent(url)}&title=${encodeURIComponent(text)}`
}

// WhatsApp用のURLを生成
// 使用するオプション: text, url
const generateWhatsAppUrl = ({ text, url }) => {
  return `https://api.whatsapp.com/send?text=${encodeURIComponent(`${text} ${url}`)}`
}

// Email用のURLを生成
// 使用するオプション: text, url
const generateEmailUrl = ({ text, url }) => {
  return `mailto:?subject=${encodeURIComponent(text)}&body=${encodeURIComponent(url)}`
}

// MastodonとMisskey用のURLを生成
// 使用するオプション: text, url, instance
const generateMastodonMisskeyUrl = ({ text, url, instance }) => {
  return `${instance}/share?text=${encodeURIComponent(`${text} ${url}`)}`
}

