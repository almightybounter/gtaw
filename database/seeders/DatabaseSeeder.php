<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Production seeder - no test data
    public function run(): void
    {
        $this->command->info('✅ Production database setup complete!');
        $this->command->info('📊 Database tables created via migrations');
        $this->command->info('🚀 Ready for production use');
    }
}
