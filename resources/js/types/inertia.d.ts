import { PageProps as InertiaPageProps } from '@inertiajs/core'
import { PageProps as AppPageProps } from './'
import { SharedData } from './Pages/share'

// PageProps タイプの定義
export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = SharedData & T;

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
