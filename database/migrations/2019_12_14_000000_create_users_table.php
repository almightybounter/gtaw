<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Create users table with proper MySQL optimization for production.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Limit length for better performance
            $table->string('email', 150)->unique(); // Indexed automatically due to unique constraint
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255); // Sufficient for bcrypt/argon2 hashes
            $table->rememberToken();
            $table->timestamps();

            // Additional indexes for performance as per project rules
            $table->index(['email', 'password']); // For login queries
            $table->index('created_at'); // For user analytics/reporting
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
