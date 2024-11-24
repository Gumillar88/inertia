<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @livewireStyles
        @livewireScripts
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
        <script src="https://cdn.jsdelivr.net/npm/vue@3.2.0/dist/vue.global.js"></script>
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

        <div id="app"></div>

        <script>
            Pusher.logToConsole = true;

            const pusher = new Pusher('b0fa0f3bb216fa7ad8c6', {
                cluster: 'ap1',
                encrypted: true,
            });
            
            const channel = pusher.subscribe('notification-test-production');

            channel.bind('my-event', function(data) {
                console.log(data);
                if (data && data.message) {
                    app.messages.push(data.message);
                } else {
                    console.error("No message received or invalid data:", data);
                }
            });

            const app = Vue.createApp({
                data() {
                    return {
                        messages: [],
                    };
                },
            });

            app.mount('#app');
        </script>
    </body>
</html>
