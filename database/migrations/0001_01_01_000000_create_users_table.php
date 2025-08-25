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
        // Create 'users' table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();  // Unique username
            $table->foreignId('user_type')->constrained('user_types')->onDelete('cascade');  // Foreign key to 'user_types' table
            $table->string('password')->nullable();  // Allow null values for password
            $table->string('created_by')->nullable();  // User who created the record
            $table->string('updated_by')->nullable();  // User who updated the record
            $table->timestamps();  // created_at and updated_at
            $table->softDeletes();  // Soft delete for the user

            // Optionally add a remember_token for session management
            $table->rememberToken();
        });

        // Create 'password_reset_tokens' table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary();  // Assuming email as primary key for password reset
            $table->string('token');  // Token for resetting password
            $table->timestamp('created_at')->nullable();  // Timestamp for token creation
        });

        // Create 'sessions' table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();  // Session ID as the primary key
            $table->foreignId('user_id')->nullable()->constrained('users')->index();  // Foreign key to users table
            $table->string('ip_address', 45)->nullable();  // IP address of the user
            $table->text('user_agent')->nullable();  // User agent (browser information)
            $table->longText('payload');  // Payload for the session
            $table->integer('last_activity')->index();  // Timestamp of the last activity
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
