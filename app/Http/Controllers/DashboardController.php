<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $userStats = [
            'total_notes' => $user->notes()->count(),
            'notes_this_month' => $user->notes()->whereMonth('created_at', now()->month)->count(),
            'notes_this_week' => $user->notes()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'notes_today' => $user->notes()->whereDate('created_at', today())->count(),
        ];

        $recentNotes = $user->notes()->latest()->limit(5)->get();

        $weeklyActivity = collect(range(6, 0))->map(function ($daysAgo) use ($user) {
            $date = now()->subDays($daysAgo);
            return [
                'date' => $date->format('M j'),
                'count' => $user->notes()->whereDate('created_at', $date)->count(),
            ];
        });

        $notesAnalysis = [
            'short_notes' => $user->notes()->whereRaw('CHAR_LENGTH(content) < 100')->count(),
            'medium_notes' => $user->notes()->whereRaw('CHAR_LENGTH(content) BETWEEN 100 AND 500')->count(),
            'long_notes' => $user->notes()->whereRaw('CHAR_LENGTH(content) > 500')->count(),
        ];

        $recentActivity = $this->getRecentActivityWithDeletes($user);

        return view('dashboard', compact(
            'userStats',
            'recentNotes',
            'weeklyActivity',
            'notesAnalysis',
            'recentActivity'
        ));
    }

    private function getRecentActivityWithDeletes(User $user): \Illuminate\Support\Collection
    {
        $existingNotesActivity = $user->notes()
            ->select('id', 'title', 'created_at', 'updated_at')
            ->latest('updated_at')
            ->limit(20)
            ->get()
            ->map(function ($note) {
                return [
                    'title' => $note->title,
                    'action' => $note->created_at->eq($note->updated_at) ? 'created' : 'updated',
                    'time' => $note->updated_at,
                    'time_diff' => $note->updated_at->diffForHumans(),
                    'note_id' => $note->id,
                    'source' => 'database'
                ];
            });

        $logActivity = $this->parseNoteActionLogs($user->id);
        
        return $existingNotesActivity->concat($logActivity)
            ->sortByDesc('time')
            ->take(15)
            ->values();
    }

    private function parseNoteActionLogs(int $userId): \Illuminate\Support\Collection
    {
        $activities = collect();
        $logPath = storage_path('logs/note_actions.log');
        
        if (!file_exists($logPath)) {
            return $activities;
        }

        try {
            $logContent = file_get_contents($logPath);
            $lines = array_reverse(explode("\n", trim($logContent)));
            $seenActions = [];
            
            foreach ($lines as $line) {
                if (empty($line)) continue;
                
                if (preg_match('/\[(.*?)\].*?"user_id":(' . $userId . ').*?"note_id":(\d+).*?"action":"(\w+)".*?"timestamp":"(.*?)"/', $line, $matches)) {
                    $noteId = (int) $matches[3];
                    $action = $matches[4];
                    $logTimestamp = $matches[5];
                    
                    if (in_array($action, ['create', 'update', 'delete'])) {
                        $actionKey = $action === 'delete' ? "delete_{$noteId}" : "{$action}_{$noteId}";
                        
                        if (isset($seenActions[$actionKey])) {
                            continue;
                        }
                        $seenActions[$actionKey] = true;
                        
                        $time = Carbon::parse($logTimestamp);
                        
                        $title = 'Unknown Note';
                        if ($action === 'delete') {
                            $title = "Deleted Note (ID: {$noteId})";
                        } else {
                            $note = Note::find($noteId);
                            if ($note && $note->user_id === $userId) {
                                $title = $note->title;
                            }
                        }
                        
                        $activities->push([
                            'title' => $title,
                            'action' => $action,
                            'time' => $time,
                            'time_diff' => $time->diffForHumans(),
                            'note_id' => $noteId,
                            'source' => 'log'
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to parse note action logs: ' . $e->getMessage());
        }

        return $activities;
    }
}
