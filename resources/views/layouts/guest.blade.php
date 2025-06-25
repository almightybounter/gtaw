<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|dancing-script:400,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                            handwritten: ['Dancing Script', 'cursive']
                        }
                    }
                }
            }
        </script>

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            body {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <a href="/" class="group">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">
                        GTAW
                    </h1>
                    <p class="text-gray-600 text-sm font-handwritten text-lg">
                        your thoughts have a home here
                    </p>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md px-8 py-8 bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-white/50">
                {{ $slot }}
            </div>
            
            <!-- Back to home link -->
            <div class="mt-6 text-center">
                <a href="/" class="text-gray-600 hover:text-gray-800 text-sm transition-colors">
                    ← Back to home
                </a>
            </div>
        </div>
    </body>
</html>
