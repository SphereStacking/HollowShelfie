import { AxiosInstance } from 'axios'
import ziggyRoute, { Config as ZiggyConfig } from 'ziggy-js'

declare global {
    interface Window {
        axios: AxiosInstance;
    }

    let route: typeof ziggyRoute
    let Ziggy: ZiggyConfig
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}
