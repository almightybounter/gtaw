<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Create notes table
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // FK index for performance
            $table->index('user_id');
        });
    }

    // Drop notes table
    public function down()
    {
        Schema::dropIfExists('notes');
    }
};
