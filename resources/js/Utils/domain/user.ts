import { usePage } from '@inertiajs/vue3'
import { PageProps } from '@/types/inertia'
import { EventShow } from '@/types/Pages/EventShow'
/**
 * ユーザーが特定の権限を持っているかどうかをチェックする関数
 *
 * @param {string | string[]} permissionNames - 権限名または権限名の配列
 * @returns {boolean} ユーザーが特定の権限を持っている場合は true、そうでない場合は false
 *
 * @example
 * 単一の権限をチェック
 * const hasPermission = userHasPermission('admin');
 *
 * @example
 * 複数の権限をチェック
 * const hasAnyPermission = userHasPermission(['admin', 'editor']);
 */
export const userHasPermission = (permissionNames: string | string[]): boolean => {
  const page = usePage<PageProps<EventShow>>()
  const auth = page.props.auth

  if (!auth || !auth.user) {
    return false
  }

  if (Array.isArray(permissionNames)) {
    return permissionNames.some(permission => auth.user.permissions.includes(permission))
  }

  return auth.user.permissions.includes(permissionNames)
}
