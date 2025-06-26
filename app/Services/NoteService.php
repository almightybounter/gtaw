<?php

namespace App\Services;

use App\Models\Note;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NoteService
{
    // Get paginated user notes with search
    public function getUserNotes(User $user, ?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $user->notes()
            ->with('user')
            ->search($search)
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);
    }

    // Create new note
    public function createNote(User $user, array $data): Note
    {
        return $user->notes()->create([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    // Update note
    public function updateNote(Note $note, array $data): bool
    {
        return $note->update([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    // Delete note
    public function deleteNote(Note $note): bool
    {
        return $note->delete();
    }

    // Get user note statistics
    public function getNoteStats(User $user): array
    {
        return [
            'total_notes' => $user->notes()->count(),
            'notes_this_month' => $user->notes()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
    }
} 