import { AxiosInstance } from 'axios'
import ziggyRoute, { Config as ZiggyConfig } from 'ziggy-js'

declare global {
    interface Window {
        axios: AxiosInstance;
        route: typeof ziggyRoute;
        Ziggy: ZiggyConfig;
    }
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}
