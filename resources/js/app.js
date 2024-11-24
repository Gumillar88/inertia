import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import Pusher from 'pusher-js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// Enable Pusher logging (remove in production)
Pusher.logToConsole = true;

const pusher = new Pusher('b0fa0f3bb216fa7ad8c6', {
    cluster: 'ap1',
    encrypted: true,
});

const channel = pusher.subscribe('notification-test-production');

// Membuat instance Vue
const app = createApp({
    data() {
        return {
            messages: [],
        };
    },
    mounted() {
        // Menerima pesan dari Pusher
        channel.bind('my-event', (data) => {
            console.log(data); // Pastikan data yang diterima ada
            if (data && data.message) {
                this.messages.push(data.message); // Sesuaikan dengan struktur data yang dikirim
            } else {
                console.error('No message received or invalid data:', data);
            }
        });
    },
});

app.mount('#app');
