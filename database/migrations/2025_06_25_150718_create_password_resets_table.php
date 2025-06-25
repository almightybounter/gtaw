<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Create password resets table for authentication with production optimization.
     */
    public function up(): void
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email', 150)->index(); // Index for fast lookups
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            
            // Performance indexes as per project rules
            $table->index(['email', 'token']); // For reset verification
            $table->index('created_at'); // For cleanup/expiration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_resets');
    }
};
