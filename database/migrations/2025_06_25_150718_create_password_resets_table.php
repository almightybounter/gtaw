<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Create password resets table
    public function up(): void
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email', 150)->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            
            // Performance indexes
            $table->index(['email', 'token']);
            $table->index('created_at');
        });
    }

    // Drop password resets table
    public function down(): void
    {
        Schema::dropIfExists('password_resets');
    }
};
