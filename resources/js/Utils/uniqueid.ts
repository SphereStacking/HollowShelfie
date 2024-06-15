/**
 * ユニークなIDを生成します。
 * @returns {string} ユニークなIDを返します。
 */
export const generateUniqueId = (prefix: string): string => {
  return prefix + '-' + Date.now().toString(36) + '-' + Math.random().toString(36).substring(2, 9)
}
