<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gtaw.test',
            'password' => bcrypt('password123'),
        ]);

        $randomUsers = User::factory()->count(9)->create();

        Note::factory()->count(5)->forUser($testUser)->create();
        Note::factory()->count(3)->recent()->forUser($testUser)->create();

        foreach ($randomUsers as $user) {
            $noteCount = rand(2, 4);
            Note::factory()->count($noteCount)->forUser($user)->create();
            
            if (rand(0, 1)) {
                Note::factory()->long()->forUser($user)->create();
            }
        }

        $allUsers = User::all();
        foreach ($allUsers->random(min(10, $allUsers->count())) as $user) {
            Note::factory()->recent()->forUser($user)->create();
        }

        Note::factory()->forUser($testUser)->create([
            'title' => 'Laravel Development Tips',
            'content' => 'This note contains various Laravel development tips and best practices for building secure web applications.',
        ]);

        Note::factory()->forUser($testUser)->create([
            'title' => 'Project Management Notes',
            'content' => 'Important notes about project management, including deadlines, team coordination, and task prioritization.',
        ]);

        Note::factory()->forUser($testUser)->create([
            'title' => 'Security Guidelines',
            'content' => 'Security best practices for web applications including CSRF protection, input validation, and secure authentication.',
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Created ' . User::count() . ' users and ' . Note::count() . ' notes.');
        $this->command->info('Test login credentials:');
        $this->command->info('User: test@gtaw.test / password123');
    }
}
