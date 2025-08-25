<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
        {
            Schema::create('registered_ids', function (Blueprint $table) {
                $table->id();
                $table->string('visitor_type', 10)->charset('utf8'); // Use utf8 instead of utf8mb4
                $table->string('id_number', 151)->charset('utf8'); // Use utf8 instead of utf8mb4
                
                // Create foreign key to the 'users' table
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                
                // Add deleted_at and deleted_by columns   
                $table->softDeletes();
                $table->string('deleted_by', 10)->nullable();
        
                // Make the combination of visitor_type and id_number unique
                $table->unique(['visitor_type', 'id_number']);
            });
        }
        
        public function down()
        {
            Schema::dropIfExists('registered_ids');
            Schema::dropIfExists('sessions');
            Schema::dropIfExists('password_reset_tokens');

        }
    };
    