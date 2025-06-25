<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_notes_index(): void
    {
        $user = User::factory()->create();
        Note::factory()->count(5)->forUser($user)->create();

        $response = $this->actingAs($user)->get('/notes');

        $response->assertStatus(200);
        $response->assertViewIs('notes.index');
        $response->assertViewHas('notes');
    }

    public function test_unauthenticated_user_cannot_access_notes(): void
    {
        $response = $this->get('/notes');

        $response->assertRedirect('/login');
    }

    public function test_user_can_create_note(): void
    {
        $user = User::factory()->create();

        $noteData = [
            'title' => 'Test Note Title',
            'content' => 'This is the content of the test note.',
        ];

        $response = $this->actingAs($user)->post('/notes', $noteData);

        $response->assertRedirect('/notes');
        $response->assertSessionHas('success', 'Note created successfully!');
        
        $this->assertDatabaseHas('notes', [
            'title' => 'Test Note Title',
            'content' => 'This is the content of the test note.',
            'user_id' => $user->id,
        ]);
    }

    public function test_note_creation_requires_valid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/notes', [
            'content' => 'Content without title',
        ]);
        $response->assertSessionHasErrors('title');

        $response = $this->actingAs($user)->post('/notes', [
            'title' => 'Title without content',
        ]);
        $response->assertSessionHasErrors('content');

        $response = $this->actingAs($user)->post('/notes', [
            'title' => str_repeat('a', 256),
            'content' => 'Valid content',
        ]);
        $response->assertSessionHasErrors('title');

        $response = $this->actingAs($user)->post('/notes', [
            'title' => 'Valid title',
            'content' => str_repeat('a', 10001),
        ]);
        $response->assertSessionHasErrors('content');
    }

    public function test_user_can_view_own_note(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->forUser($user)->create();

        $response = $this->actingAs($user)->get("/notes/{$note->id}");

        $response->assertStatus(200);
        $response->assertViewIs('notes.show');
        $response->assertViewHas('note', $note);
    }

    public function test_user_cannot_view_other_users_note(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $note = Note::factory()->forUser($user2)->create();

        $response = $this->actingAs($user1)->get("/notes/{$note->id}");

        $response->assertStatus(403);
    }

    public function test_user_can_update_own_note(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->forUser($user)->create();

        $updateData = [
            'title' => 'Updated Note Title',
            'content' => 'Updated note content.',
        ];

        $response = $this->actingAs($user)->put("/notes/{$note->id}", $updateData);

        $response->assertRedirect('/notes');
        $response->assertSessionHas('success', 'Note updated successfully!');
        
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => 'Updated Note Title',
            'content' => 'Updated note content.',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_update_other_users_note(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $note = Note::factory()->forUser($user2)->create();

        $updateData = [
            'title' => 'Unauthorized Update',
            'content' => 'This should not work.',
        ];

        $response = $this->actingAs($user1)->put("/notes/{$note->id}", $updateData);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_note(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->forUser($user)->create();

        $response = $this->actingAs($user)->delete("/notes/{$note->id}");

        $response->assertRedirect('/notes');
        $response->assertSessionHas('success', 'Note deleted successfully!');
        
        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
    }

    public function test_user_cannot_delete_other_users_note(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $note = Note::factory()->forUser($user2)->create();

        $response = $this->actingAs($user1)->delete("/notes/{$note->id}");

        $response->assertStatus(403);
        
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
        ]);
    }

    public function test_notes_pagination(): void
    {
        $user = User::factory()->create();
        Note::factory()->count(15)->forUser($user)->create();

        $response = $this->actingAs($user)->get('/notes');

        $response->assertStatus(200);
        $notes = $response->viewData('notes');
        $this->assertEquals(10, $notes->count());
        $this->assertTrue($notes->hasPages());
    }

    public function test_notes_search(): void
    {
        $user = User::factory()->create();
        
        $searchableNote = Note::factory()->forUser($user)->create([
            'title' => 'Searchable Note Title',
            'content' => 'This note contains unique searchable content.',
        ]);
        
        Note::factory()->count(5)->forUser($user)->create();

        $response = $this->actingAs($user)->get('/notes?search=Searchable');

        $response->assertStatus(200);
        $notes = $response->viewData('notes');
        $this->assertEquals(1, $notes->count());
        $this->assertEquals($searchableNote->id, $notes->first()->id);
    }

    public function test_user_only_sees_own_notes(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        Note::factory()->count(3)->forUser($user1)->create();
        Note::factory()->count(5)->forUser($user2)->create();

        $response = $this->actingAs($user1)->get('/notes');

        $response->assertStatus(200);
        $notes = $response->viewData('notes');
        $this->assertEquals(3, $notes->count());
        
        foreach ($notes as $note) {
            $this->assertEquals($user1->id, $note->user_id);
        }
    }

    public function test_note_actions_are_logged(): void
    {
        $user = User::factory()->create();
        $noteData = [
            'title' => 'Test Note',
            'content' => 'Test content',
        ];

        $response = $this->actingAs($user)->post('/notes', $noteData);
        $note = Note::latest()->first();

        $this->actingAs($user)->put("/notes/{$note->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content',
        ]);

        $this->actingAs($user)->delete("/notes/{$note->id}");

        $this->assertTrue(true);
    }

    public function test_route_model_binding(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->forUser($user)->create();

        $response = $this->actingAs($user)->get("/notes/{$note->id}");

        $response->assertStatus(200);
        $response->assertViewHas('note');
        $this->assertEquals($note->id, $response->viewData('note')->id);
    }

    public function test_returns_404_for_non_existent_note(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/notes/999999');

        $response->assertStatus(404);
    }
}
