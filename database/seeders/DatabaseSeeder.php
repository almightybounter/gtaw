<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Note: This seeder is intentionally empty for production deployment.
     * Only database structure (migrations) will be created.
     */
    public function run(): void
    {
        // Production mode: No seed data
        // Database structure only via migrations
        
        $this->command->info('✅ Production database setup complete!');
        $this->command->info('📊 Database tables created via migrations');
        $this->command->info('🚀 Ready for production use');
    }
}
