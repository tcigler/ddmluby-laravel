import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import AppLayout from "@/Layouts/AppLayout.vue";
import {definePreset} from "@primeuix/themes";

import dayjs from "dayjs";
import "dayjs/locale/cs"
import localeData from 'dayjs/plugin/localeData'
import localizedFormat from 'dayjs/plugin/localizedFormat'

dayjs.extend(localeData);
dayjs.extend(localizedFormat);
dayjs.locale("cs")

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const MyPreset = definePreset(Aura, {
    semantic: {
        colorScheme: {
            light: {
                primary: {
                    0: '#ffffff',
                    50: '{cyan.50}',
                    100: '{cyan.100}',
                    200: '{cyan.200}',
                    300: '{cyan.300}',
                    400: '{cyan.400}',
                    500: '{cyan.500}',
                    600: '{cyan.600}',
                    700: '{cyan.700}',
                    800: '{cyan.800}',
                    900: '{cyan.900}',
                    950: '{cyan.950}'
                },
                surface: {
                    0: '#ffffff',
                    50: '{zinc.50}',
                    100: '{zinc.100}',
                    200: '{zinc.200}',
                    300: '{zinc.300}',
                    400: '{zinc.400}',
                    500: '{zinc.500}',
                    600: '{zinc.600}',
                    700: '{zinc.700}',
                    800: '{zinc.800}',
                    900: '{zinc.900}',
                    950: '{zinc.950}'
                }
            },
            dark: {
                primary: {
                    0: '#ffffff',
                    50: '{cyan.50}',
                    100: '{cyan.100}',
                    200: '{cyan.200}',
                    300: '{cyan.300}',
                    400: '{cyan.400}',
                    500: '{cyan.500}',
                    600: '{cyan.600}',
                    700: '{cyan.700}',
                    800: '{cyan.800}',
                    900: '{cyan.900}',
                    950: '{cyan.950}'
                },
                surface: {
                    0: '#ffffff',
                    50: '{slate.50}',
                    100: '{slate.100}',
                    200: '{slate.200}',
                    300: '{slate.300}',
                    400: '{slate.400}',
                    500: '{slate.500}',
                    600: '{slate.600}',
                    700: '{slate.700}',
                    800: '{slate.800}',
                    900: '{slate.900}',
                    950: '{slate.950}'
                }
            }
        }
    }
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
        page.then((module) => {
            let defaultLayout = AppLayout; // (name.startsWith("Admin/")) ? AdminLayout : AppLayout
            module.default.layout = module.default.layout || defaultLayout;
        });
        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                // unstyled: true,
                theme: {
                    preset: MyPreset,
                    options: {
                        cssLayer: {
                            name: 'primevue',
                            order: 'theme, base, primevue'
                        }
                    }
                }
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
