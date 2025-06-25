<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GTAW') }} - Secure Personal Notes</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-4px);
        }
    </style>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            📝 GTAW Notes
                        </h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="{{ route('notes.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            My Notes
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="gradient-bg">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white">
                    Your Ideas, <span class="text-yellow-300">Secured</span>
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-100">
                    Professional-grade note-taking application built with Laravel 9. 
                    Create, organize, and secure your thoughts with enterprise-level security.
                </p>
                <div class="mt-10 flex justify-center space-x-4">
                    @guest
                        <a href="{{ route('register') }}" class="bg-white text-indigo-600 hover:bg-gray-50 px-8 py-3 rounded-lg text-lg font-semibold shadow-lg transition duration-300">
                            🚀 Start Taking Notes
                        </a>
                        <a href="{{ route('login') }}" class="border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold transition duration-300">
                            Sign In
                        </a>
                    @else
                        <a href="{{ route('notes.index') }}" class="bg-white text-indigo-600 hover:bg-gray-50 px-8 py-3 rounded-lg text-lg font-semibold shadow-lg transition duration-300">
                            📝 View My Notes
                        </a>
                        <a href="{{ route('notes.create') }}" class="border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold transition duration-300">
                            ➕ Create Note
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    @auth
    <div class="bg-gray-800 dark:bg-gray-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white mb-8">Your Note Statistics</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-yellow-400">{{ auth()->user()->notes()->count() }}</div>
                        <div class="text-gray-300">Total Notes</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-green-400">{{ auth()->user()->notes()->whereMonth('created_at', now()->month)->count() }}</div>
                        <div class="text-gray-300">This Month</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-blue-400">{{ auth()->user()->notes()->whereDate('created_at', today())->count() }}</div>
                        <div class="text-gray-300">Today</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <!-- Features Section -->
    <div class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">
                    ✨ Powerful Features
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-12">
                    Everything you need for professional note management
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Security Feature -->
                <div class="feature-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="text-4xl mb-4">🛡️</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Enterprise Security</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Bank-level security with CSRF protection, encrypted passwords, and user authorization. Your notes are safe.
                    </p>
                </div>

                <!-- CRUD Feature -->
                <div class="feature-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="text-4xl mb-4">📋</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Full CRUD Operations</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Create, read, update, and delete notes with intuitive interface. Complete note management at your fingertips.
                    </p>
                </div>

                <!-- Search Feature -->
                <div class="feature-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="text-4xl mb-4">🔍</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Smart Search</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Find your notes instantly by searching through titles and content. Never lose a thought again.
                    </p>
                </div>

                <!-- Performance Feature -->
                <div class="feature-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Lightning Fast</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Optimized database queries, pagination, and caching. Built for performance with Laravel 9.
                    </p>
                </div>

                <!-- Logging Feature -->
                <div class="feature-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Activity Tracking</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Complete audit trail with custom logging. Track all note operations with timestamps and user data.
                    </p>
                </div>

                <!-- Dark Mode Feature -->
                <div class="feature-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="text-4xl mb-4">🌙</div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Dark Mode Ready</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Beautiful interface that adapts to your preference. Easy on the eyes, day or night.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tech Stack Section -->
    <div class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">
                    🏗️ Built with Modern Technology
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-12">
                    Professional-grade architecture following industry best practices
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-red-100 dark:bg-red-900 p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <span class="text-2xl">🐘</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Laravel 9</h3>
                    <p class="text-gray-600 dark:text-gray-400">Modern PHP framework</p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <span class="text-2xl">🔒</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Laravel Breeze</h3>
                    <p class="text-gray-600 dark:text-gray-400">Authentication system</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 dark:bg-green-900 p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <span class="text-2xl">🧪</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Pest Testing</h3>
                    <p class="text-gray-600 dark:text-gray-400">Modern testing framework</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <span class="text-2xl">💎</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">PSR-12</h3>
                    <p class="text-gray-600 dark:text-gray-400">Coding standards</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Code Quality Section -->
    <div class="bg-white dark:bg-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-12">
                    🎯 Enterprise-Grade Code Quality
                </h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Architecture Excellence</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3">✅</span>
                            <span class="text-gray-700 dark:text-gray-300"><strong>MVC Pattern:</strong> Thin controllers, business logic in services</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3">✅</span>
                            <span class="text-gray-700 dark:text-gray-300"><strong>Type Safety:</strong> PHP 8.0+ type hints throughout</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3">✅</span>
                            <span class="text-gray-700 dark:text-gray-300"><strong>Validation:</strong> FormRequest classes for security</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3">✅</span>
                            <span class="text-gray-700 dark:text-gray-300"><strong>Database:</strong> Indexed foreign keys, optimized queries</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Security First</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3">🛡️</span>
                            <span class="text-gray-700 dark:text-gray-300"><strong>CSRF Protection:</strong> All forms secured</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3">🛡️</span>
                            <span class="text-gray-700 dark:text-gray-300"><strong>Authorization:</strong> Users access only their data</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3">🛡️</span>
                            <span class="text-gray-700 dark:text-gray-300"><strong>SQL Injection:</strong> Protected with Eloquent ORM</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-3">🛡️</span>
                            <span class="text-gray-700 dark:text-gray-300"><strong>Mass Assignment:</strong> Protected with fillable arrays</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="gradient-bg">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-6">
                    Ready to Start Taking Notes?
                </h2>
                <p class="text-xl text-gray-100 mb-10 max-w-2xl mx-auto">
                    Join thousands of users who trust GTAW for their note-taking needs. 
                    Your ideas deserve the best protection and organization.
                </p>
                @guest
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('register') }}" class="bg-white text-indigo-600 hover:bg-gray-50 px-8 py-3 rounded-lg text-lg font-semibold shadow-lg transition duration-300">
                            🚀 Create Free Account
                        </a>
                        <a href="{{ route('login') }}" class="border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold transition duration-300">
                            Sign In Now
                        </a>
                    </div>
                @else
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('notes.create') }}" class="bg-white text-indigo-600 hover:bg-gray-50 px-8 py-3 rounded-lg text-lg font-semibold shadow-lg transition duration-300">
                            ✨ Create Your First Note
                        </a>
                        <a href="{{ route('notes.index') }}" class="border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold transition duration-300">
                            📝 View All Notes
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400">
                    &copy; {{ date('Y') }} GTAW Notes. Built with ❤️ using Laravel {{ app()->version() }}, PHP {{ PHP_VERSION }}, and Laravel Breeze.
                </p>
                <p class="text-gray-500 mt-2 text-sm">
                    Professional-grade note-taking application with enterprise security and modern architecture.
                </p>
            </div>
        </div>
    </footer>

    <!-- Dark Mode Toggle Script -->
    <script>
        // Simple dark mode toggle (can be enhanced)
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</body>
</html> 