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
                $table->integer('visitor_type');
                $table->string('id_number', 151);
                
                // Create foreign key to the 'users' table
                $table->integer('created_by')->nullable();
                $table->integer('updated_by')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                
                // Add deleted_at and deleted_by columns   
                $table->softDeletes();
                $table->integer('deleted_by')->nullable();
        
                // Make the combination of visitor_type and id_number unique
                $table->unique(['id_number']);
            });
        }
        
        public function down()
        {
            Schema::dropIfExists('registered_ids');
        }
    };
    