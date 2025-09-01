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
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('user_type');  
            $table->string('password')->nullable();  
            $table->string('created_by')->nullable(); 
            $table->string('updated_by')->nullable(); 
            $table->timestamps(); 
            $table->softDeletes();  
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
