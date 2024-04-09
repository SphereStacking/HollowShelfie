
// Twitter用のURLを生成
// 使用するオプション: text, url, hashtags, mention
export function generateTwitterUrl ({ text, hashtags }) {
  let twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}`
  // ハッシュタグの配列を処理
  if (Array.isArray(hashtags)) {
    const formattedHashtags = hashtags.map(tag => tag.startsWith('') ? tag : `#${tag}`).join(' ')
    twitterUrl += `&hashtags=${encodeURIComponent(formattedHashtags)}`
  }
  return twitterUrl
}

// // Facebook用のURLを生成
// // 使用するオプション: url
// const generateFacebookUrl = ({ url }) => {
//   return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`
// }

// // LinkedIn用のURLを生成
// // 使用するオプション: url
// const generateLinkedInUrl = ({ url }) => {
//   return `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`
// }

// // Reddit用のURLを生成
// // 使用するオプション: text, url
// const generateRedditUrl = ({ text, url }) => {
//   return `https://www.reddit.com/submit?url=${encodeURIComponent(url)}&title=${encodeURIComponent(text)}`
// }

// // WhatsApp用のURLを生成
// // 使用するオプション: text, url
// const generateWhatsAppUrl = ({ text, url }) => {
//   return `https://api.whatsapp.com/send?text=${encodeURIComponent(`${text} ${url}`)}`
// }

// // Email用のURLを生成
// // 使用するオプション: text, url
// const generateEmailUrl = ({ text, url }) => {
//   return `mailto:?subject=${encodeURIComponent(text)}&body=${encodeURIComponent(url)}`
// }

// // MastodonとMisskey用のURLを生成
// // 使用するオプション: text, url, instance
// const generateMastodonMisskeyUrl = ({ text, url, instance }) => {
//   return `${instance}/share?text=${encodeURIComponent(`${text} ${url}`)}`
// }

