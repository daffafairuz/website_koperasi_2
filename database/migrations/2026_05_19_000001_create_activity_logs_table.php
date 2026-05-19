<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Admin who performed the change
            $table->foreignId('target_user_id')->constrained('users')->cascadeOnDelete(); // User being modified
            $table->string('action'); // e.g. 'update_user'
            $table->text('changes')->nullable(); // JSON string containing old vs new values
            $table->string('proof_path')->nullable(); // File upload path for proof of payment
            $table->text('notes')->nullable(); // Remarks from the admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
