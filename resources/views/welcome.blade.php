<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GTAW - Where Your Thoughts Live</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: linear-gradient(180deg, #fdfbfb 0%, #f7f5f3 100%);
        }
        .handwriting {
            font-family: 'Caveat', cursive;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-full">
    <!-- Simple Navigation -->
    <nav class="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">✏️</span>
                    <span class="text-xl font-semibold text-gray-800">GTAW</span>
                </div>
                <div class="flex items-center space-x-6">
                    @auth
                        <a href="{{ route('notes.index') }}" class="text-gray-600 hover:text-gray-900">My Notes</a>
                        <a href="{{ route('dashboard') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Sign In</a>
                        <a href="{{ route('register') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">Start Writing</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="max-w-6xl mx-auto px-6 py-16">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                Finally, a place for your 
                <span class="handwriting text-blue-600 text-6xl md:text-7xl">thoughts</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                We all have ideas floating around in our heads. GTAW gives them a home. 
                Simple, secure, and actually pleasant to use.
            </p>
            @guest
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('register') }}" class="bg-gray-900 text-white px-8 py-3 rounded-lg font-medium hover:bg-gray-800 transition text-lg">
                        Start writing for free
                    </a>
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 underline">
                        Already have an account?
                    </a>
                </div>
            @else
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('notes.create') }}" class="bg-gray-900 text-white px-8 py-3 rounded-lg font-medium hover:bg-gray-800 transition text-lg">
                        Write something new
                    </a>
                    <a href="{{ route('notes.index') }}" class="text-gray-600 hover:text-gray-900 underline">
                        See your notes ({{ auth()->user()->notes()->count() }})
                    </a>
                </div>
            @endguest
        </div>
    </section>

    <!-- What Makes It Different -->
    <section class="max-w-6xl mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Why people actually use GTAW</h2>
            <p class="text-gray-600">No fluff. Just the stuff that actually matters.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🔒</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Your stuff stays yours</h3>
                <p class="text-gray-600">
                    No one can see your notes but you. We don't read them, sell them, or do anything weird with them.
                </p>
            </div>

            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">⚡</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Actually fast</h3>
                <p class="text-gray-600">
                    No waiting around. Click, type, save. Done. Your thoughts move as fast as you do.
                </p>
            </div>

            <div class="text-center">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🎯</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Just notes. That's it.</h3>
                <p class="text-gray-600">
                    No social features, no AI suggestions, no distractions. Write your thoughts and find them later.
                </p>
            </div>
        </div>
    </section>

    <!-- Real Talk Section -->
    <section class="bg-white border-t border-b border-gray-200 py-16">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Real talk</h2>
                <div class="text-lg text-gray-700 space-y-4 text-left max-w-2xl mx-auto">
                    <p>
                        Look, there are a million note-taking apps out there. Most of them are either too complicated, 
                        too expensive, or trying to do everything for everyone.
                    </p>
                    <p>
                        GTAW isn't revolutionary. It's just a place to write stuff down and find it later. 
                        Sometimes that's exactly what you need.
                    </p>
                    <p>
                        It's free, it works, and it gets out of your way. That's the whole pitch.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Simple Stats -->
    @auth
    <section class="max-w-6xl mx-auto px-6 py-16">
        <div class="bg-gray-900 rounded-2xl p-8 text-white text-center">
            <h3 class="text-2xl font-semibold mb-6">Your writing so far</h3>
            <div class="grid grid-cols-3 gap-8">
                <div>
                    <div class="text-3xl font-bold text-blue-400">{{ auth()->user()->notes()->count() }}</div>
                    <div class="text-gray-400">notes written</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-green-400">{{ auth()->user()->notes()->whereMonth('created_at', now()->month)->count() }}</div>
                    <div class="text-gray-400">this month</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-purple-400">{{ auth()->user()->created_at->diffForHumans() }}</div>
                    <div class="text-gray-400">member since</div>
                </div>
            </div>
        </div>
    </section>
    @endauth

    <!-- Get Started -->
    <section class="max-w-6xl mx-auto px-6 py-16 text-center">
        <h2 class="text-4xl font-bold text-gray-900 mb-6">Ready to give it a try?</h2>
        <p class="text-xl text-gray-600 mb-8">
            It takes about 30 seconds to sign up. No credit card, no commitment.
        </p>
        @guest
            <a href="{{ route('register') }}" class="inline-block bg-gray-900 text-white px-8 py-4 rounded-lg font-medium hover:bg-gray-800 transition text-lg">
                Start writing →
            </a>
        @else
            <a href="{{ route('notes.create') }}" class="inline-block bg-gray-900 text-white px-8 py-4 rounded-lg font-medium hover:bg-gray-800 transition text-lg">
                Write your next note →
            </a>
        @endguest
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white mt-16">
        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <span class="text-xl">✏️</span>
                    <span class="font-semibold text-gray-800">GTAW</span>
                    <span class="text-gray-500">• A simple place for your thoughts</span>
                </div>
                <div class="text-sm text-gray-500">
                    Made with Laravel {{ app()->version() }} • {{ date('Y') }}
                </div>
            </div>
        </div>
    </footer>
</body>
</html> 