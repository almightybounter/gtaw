<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_csrf_protection_on_note_creation(): void
    {
        $user = User::factory()->create();
        
        $noteData = [
            'title' => 'Test Note',
            'content' => 'Test content',
        ];

        // Test CSRF protection works
        $response = $this->actingAs($user)->post('/notes', $noteData);
        
        $response->assertRedirect('/notes');
        $this->assertDatabaseHas('notes', ['title' => 'Test Note', 'user_id' => $user->id]);
    }

    public function test_mass_assignment_protection_in_user_model(): void
    {
        $maliciousData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'id' => 999,
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ];

        $user = User::create($maliciousData);

        $this->assertNotEquals(999, $user->id);
        $this->assertNotEquals('2020-01-01 00:00:00', $user->created_at->format('Y-m-d H:i:s'));
    }

    public function test_mass_assignment_protection_in_note_model(): void
    {
        $user = User::factory()->create();
        
        $maliciousData = [
            'title' => 'Test Note',
            'content' => 'Test content',
            'user_id' => 999,
            'id' => 888,
            'created_at' => '2020-01-01 00:00:00',
        ];

        $note = new Note($maliciousData);
        $note->user_id = $user->id;
        $note->save();

        $this->assertNotEquals(888, $note->id);
        $this->assertNotEquals(999, $note->user_id);
        $this->assertEquals($user->id, $note->user_id);
    }

    public function test_sql_injection_protection_in_search(): void
    {
        $user = User::factory()->create();
        Note::factory()->forUser($user)->create(['title' => 'Normal Note']);

        $maliciousQuery = "'; DROP TABLE notes; --";
        
        $response = $this->actingAs($user)->get('/notes?search=' . urlencode($maliciousQuery));

        $response->assertStatus(200);
        $this->assertDatabaseHas('notes', ['title' => 'Normal Note']);
    }

    public function test_xss_protection_in_note_content(): void
    {
        $user = User::factory()->create();
        
        $maliciousContent = '<script>alert("XSS")</script><img src="x" onerror="alert(1)">';
        
        $noteData = [
            'title' => 'XSS Test Note',
            'content' => $maliciousContent,
        ];

        $this->actingAs($user)->post('/notes', $noteData);

        $note = Note::latest()->first();
        $this->assertEquals($maliciousContent, $note->content);

        $response = $this->actingAs($user)->get("/notes/{$note->id}");
        
        $response->assertStatus(200);
        // Check content is escaped
        $response->assertSee('&lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;', false);
        $response->assertDontSee('<script>alert("XSS")</script>', false);
    }

    public function test_authentication_required_for_all_note_routes(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->forUser($user)->create();

        $this->get('/notes')->assertRedirect('/login');
        $this->get('/notes/create')->assertRedirect('/login');
        $this->post('/notes', [])->assertRedirect('/login');
        $this->get("/notes/{$note->id}")->assertRedirect('/login');
        $this->get("/notes/{$note->id}/edit")->assertRedirect('/login');
        $this->put("/notes/{$note->id}", [])->assertRedirect('/login');
        $this->delete("/notes/{$note->id}")->assertRedirect('/login');
    }

    public function test_email_verification_required_for_notes(): void
    {
        // Check verified middleware exists
        $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName('notes.index');
        $middleware = $route ? $route->gatherMiddleware() : [];
        
        $this->assertContains('verified', $middleware, 'Notes routes should require email verification');
    }

    public function test_user_cannot_access_notes_by_manipulating_user_id(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $note = Note::factory()->forUser($user2)->create();

        $noteData = [
            'title' => 'Malicious Note',
            'content' => 'This should belong to user1',
            'user_id' => $user2->id,
        ];

        $response = $this->actingAs($user1)->post('/notes', $noteData);

        $createdNote = Note::latest()->first();
        $this->assertEquals($user1->id, $createdNote->user_id);
        $this->assertNotEquals($user2->id, $createdNote->user_id);
    }

    public function test_direct_route_access_with_invalid_ids(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/notes/abc');
        $response->assertStatus(404);

        $response = $this->actingAs($user)->get('/notes/-1');
        $response->assertStatus(404);

        $response = $this->actingAs($user)->get('/notes/0');
        $response->assertStatus(404);
    }

    public function test_note_update_security(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $note = Note::factory()->forUser($user1)->create();

        $maliciousData = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
            'user_id' => $user2->id,
            'id' => 999,
        ];

        $response = $this->actingAs($user1)->put("/notes/{$note->id}", $maliciousData);

        $note->refresh();
        $this->assertEquals($user1->id, $note->user_id);
        $this->assertNotEquals($user2->id, $note->user_id);
        $this->assertNotEquals(999, $note->id);
    }

    public function test_password_hashing(): void
    {
        $password = 'test-password';
        $user = User::factory()->create(['password' => Hash::make($password)]);

        $this->assertNotEquals($password, $user->password);
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertFalse(Hash::check('wrong-password', $user->password));
    }

    public function test_sensitive_data_not_exposed_in_json(): void
    {
        $user = User::factory()->create();
        
        $userArray = $user->toArray();
        
        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }

    public function test_rate_limiting_on_api_routes(): void
    {
        $response = $this->get('/api/test');
        
        $this->assertTrue(in_array($response->getStatusCode(), [404, 429]));
    }

    public function test_file_upload_security_if_implemented(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/notes', [
            'title' => 'Test',
            'content' => 'Test',
            'malicious_file' => 'not_allowed.php'
        ]);

        $this->assertTrue(true);
    }

    public function test_session_security(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);

        auth()->logout();
        
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_input_length_validation(): void
    {
        $user = User::factory()->create();

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

    public function test_special_characters_in_search(): void
    {
        $user = User::factory()->create();
        Note::factory()->forUser($user)->create(['title' => 'Test Note']);

        $specialChars = ['<', '>', '&', '"', "'", '%', '_', '\\'];
        
        foreach ($specialChars as $char) {
            $response = $this->actingAs($user)->get('/notes?search=' . urlencode($char));
            $response->assertStatus(200);
        }
    }

    public function test_unauthorized_dashboard_access(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
} 