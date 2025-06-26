<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    private NoteService $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
        $this->middleware('auth');
    }

    // List user notes with search
    public function index(Request $request)
    {
        $notes = $this->noteService->getUserNotes(
            $request->user(),
            $request->get('search'),
            10
        );

        return view('notes.index', compact('notes'));
    }

    // Show create form
    public function create()
    {
        return view('notes.create');
    }

    // Store new note + log action
    public function store(StoreNoteRequest $request)
    {
        $note = $this->noteService->createNote(
            $request->user(),
            $request->validated()
        );

        Log::channel('note_actions')->info('Note created', [
            'user_id' => $request->user()->id,
            'note_id' => $note->id,
            'action' => 'create',
            'timestamp' => now()
        ]);

        return redirect()->route('notes.index')
            ->with('success', 'Note created successfully!');
    }

    // Show single note (owner only)
    public function show(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('notes.show', compact('note'));
    }

    // Show edit form (owner only)
    public function edit(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('notes.edit', compact('note'));
    }

    // Update note + log action (owner only)
    public function update(UpdateNoteRequest $request, Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->noteService->updateNote($note, $request->validated());

        Log::channel('note_actions')->info('Note updated', [
            'user_id' => $request->user()->id,
            'note_id' => $note->id,
            'action' => 'update',
            'timestamp' => now()
        ]);

        return redirect()->route('notes.index')
            ->with('success', 'Note updated successfully!');
    }

    // Delete note + log action (owner only)
    public function destroy(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $noteId = $note->id;
        $this->noteService->deleteNote($note);

        Log::channel('note_actions')->info('Note deleted', [
            'user_id' => auth()->id(),
            'note_id' => $noteId,
            'action' => 'delete',
            'timestamp' => now()
        ]);

        return redirect()->route('notes.index')
            ->with('success', 'Note deleted successfully!');
    }
}
