/**
 * 現在の環境モードを取得します。
 * @returns {string} 環境モードを返します。
 */
export const getEnvironment = () => {
  return import.meta.env.MODE
}

/**
 * 開発環境かどうかを判断します。
 * @returns {boolean} 開発環境の場合はtrueを返します。
 */
export const isDevelopment = () => {
  return getEnvironment() === 'development'
}

/**
 * 本番環境かどうかを判断します。
 * @returns {boolean} 本番環境の場合はtrueを返します。
 */
export const isProduction = () => {
  return getEnvironment() === 'production'
}
