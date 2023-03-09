import './bootstrap';
import '../scss/app.scss';
import 'vue-toastification/dist/index.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import Toast from "vue-toastification";

import { ZiggyVue } from "ziggy";
import { Ziggy } from "./ziggy";

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast, { position: "top-right", timeout: 2500 })
            .mount(el);
    },
})
