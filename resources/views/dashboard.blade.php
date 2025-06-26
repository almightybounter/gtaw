<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Welcome back, {{ Auth::user()->name }}!
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Notes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Notes</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $userStats['total_notes'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- This Month -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">This Month</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $userStats['notes_this_month'] }}</p>
                            </div>
                            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- This Week -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">This Week</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $userStats['notes_this_week'] }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $userStats['notes_today'] }}</p>
                            </div>
                            <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Welcome Section -->
            <div class="bg-gradient-to-r from-green-500 to-blue-600 rounded-lg shadow-lg">
                <div class="p-6 text-white">
                    <h3 class="text-lg font-semibold mb-2">Welcome to Your Personal Notes Dashboard</h3>
                    <p class="text-sm opacity-90">Manage your notes, track your progress, and stay organized with your personal note-taking system.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Weekly Activity Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Weekly Activity</h3>
                        <div class="space-y-2">
                            @foreach($weeklyActivity as $day)
                            <div class="flex items-center">
                                <div class="w-16 text-sm text-gray-600 dark:text-gray-400">{{ $day['date'] }}</div>
                                <div class="flex-1 ml-4">
                                    <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-4 relative">
                                        <div class="bg-blue-500 h-4 rounded-full transition-all duration-300" 
                                             style="width: {{ $userStats['total_notes'] > 0 ? ($day['count'] / max($weeklyActivity->max('count'), 1) * 100) : 0 }}%"></div>
                                        <span class="absolute inset-0 flex items-center justify-center text-xs font-medium text-white">
                                            {{ $day['count'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Notes Analysis -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Notes Analysis</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Short Notes (&lt;100 chars)</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $notesAnalysis['short_notes'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Medium Notes (100-500 chars)</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $notesAnalysis['medium_notes'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Long Notes (&gt;500 chars)</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $notesAnalysis['long_notes'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Notes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Notes</h3>
                            <a href="{{ route('notes.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                                View All →
                            </a>
                        </div>
                        @if($recentNotes->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentNotes as $note)
                                <div class="border-l-4 border-blue-400 pl-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                        <a href="{{ route('notes.show', $note) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                            {{ Str::limit($note->title, 40) }}
                                        </a>
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ Str::limit($note->content, 80) }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                        {{ $note->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">No notes yet</p>
                                <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                    Create Your First Note
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Activity</h3>
                        @if($recentActivity->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentActivity as $activity)
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($activity['action'] === 'created')
                                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </div>
                                        @elseif($activity['action'] === 'delete')
                                            <div class="w-8 h-8 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900 dark:text-gray-100">
                                            <span class="font-medium {{ $activity['action'] === 'delete' ? 'text-red-600 dark:text-red-400' : '' }}">{{ ucfirst($activity['action']) }}</span>
                                            @if($activity['action'] === 'delete')
                                                <span class="text-red-600 dark:text-red-400">"{{ Str::limit($activity['title'], 30) }}"</span>
                                            @else
                                                "{{ Str::limit($activity['title'], 30) }}"
                                            @endif
                                            @if(isset($activity['source']) && $activity['source'] === 'log')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 ml-2">
                                                    Log
                                                </span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['time_diff'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent activity</p>
                        @endif
                    </div>
                </div>
            </div>



            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('notes.create') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900 hover:bg-blue-100 dark:hover:bg-blue-800 rounded-lg transition-colors">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-blue-900 dark:text-blue-100">New Note</p>
                                <p class="text-sm text-blue-700 dark:text-blue-300">Create a new note</p>
                            </div>
                        </a>

                        <a href="{{ route('notes.index') }}" class="flex items-center p-4 bg-green-50 dark:bg-green-900 hover:bg-green-100 dark:hover:bg-green-800 rounded-lg transition-colors">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-green-900 dark:text-green-100">View Notes</p>
                                <p class="text-sm text-green-700 dark:text-green-300">Browse all notes</p>
                            </div>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="flex items-center p-4 bg-purple-50 dark:bg-purple-900 hover:bg-purple-100 dark:hover:bg-purple-800 rounded-lg transition-colors">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-purple-900 dark:text-purple-100">Profile</p>
                                <p class="text-sm text-purple-700 dark:text-purple-300">Edit profile</p>
                            </div>
                        </a>

                        <a href="{{ route('notes.index', ['search' => '']) }}" class="flex items-center p-4 bg-yellow-50 dark:bg-yellow-900 hover:bg-yellow-100 dark:hover:bg-yellow-800 rounded-lg transition-colors">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-yellow-900 dark:text-yellow-100">Search</p>
                                <p class="text-sm text-yellow-700 dark:text-yellow-300">Find notes</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive JavaScript -->
    <script>
        // Add smooth transitions and hover effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add click animations to stat cards
            const statCards = document.querySelectorAll('.bg-white.dark\\:bg-gray-800');
            statCards.forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 100);
                });
            });

            // Auto-refresh statistics every 5 minutes
            setTimeout(function() {
                window.location.reload();
            }, 300000); // 5 minutes

            // Add loading animations for quick action buttons

            const quickActionButtons = document.querySelectorAll('a[href*="notes"]');
            quickActionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const svg = this.querySelector('svg');
                    if (svg) {
                        svg.style.animation = 'spin 0.5s linear';
                    }
                });
            });

            // Progressive enhancement for activity chart
            const activityBars = document.querySelectorAll('.bg-blue-500');
            activityBars.forEach((bar, index) => {
                setTimeout(() => {
                    bar.style.opacity = '0';
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.transition = 'all 0.8s ease-out';
                        bar.style.opacity = '1';
                        bar.style.width = bar.getAttribute('data-width') || bar.style.width;
                    }, 100);
                }, index * 200);
            });

            // Add tooltips to statistics
            const statNumbers = document.querySelectorAll('.text-3xl.font-bold');
            statNumbers.forEach(number => {
                number.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.2s ease';
                });
                number.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Real-time clock in header
            function updateClock() {
                const now = new Date();
                const timeString = now.toLocaleTimeString();
                const dateString = now.toLocaleDateString();
                
                // Find or create clock element
                let clockElement = document.getElementById('dashboard-clock');
                if (!clockElement) {
                    const headerDiv = document.querySelector('div.text-sm.text-gray-600');
                    if (headerDiv) {
                        clockElement = document.createElement('div');
                        clockElement.id = 'dashboard-clock';
                        clockElement.className = 'text-xs text-gray-500 dark:text-gray-500 mt-1';
                        headerDiv.appendChild(clockElement);
                    }
                }
                
                if (clockElement) {
                    clockElement.textContent = `${dateString} ${timeString}`;
                }
            }
            
            // Update clock every second
            updateClock();
            setInterval(updateClock, 1000);

            // Add pulse animation to new note counts
            const todayCount = document.querySelector('.border-purple-500 .text-3xl');
            if (todayCount && parseInt(todayCount.textContent) > 0) {
                todayCount.style.animation = 'pulse 2s infinite';
            }
        });

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.7; }
            }
            
            .hover-lift:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }
            
            .stat-card {
                transition: all 0.3s ease;
            }
            
            .stat-card:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
        `;
        document.head.appendChild(style);

        // Add hover classes to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.bg-white.dark\\:bg-gray-800');
            cards.forEach(card => {
                card.classList.add('hover-lift', 'stat-card');
            });
        });
    </script>
</x-app-layout>
