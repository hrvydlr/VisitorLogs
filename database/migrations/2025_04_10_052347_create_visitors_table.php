<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('number')->nullable();
            $table->string('address')->nullable();
            $table->string('visitor_type');
            $table->string('id_number')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image')->nullable(); // Added image column
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('status')->default('active'); // Added status column
            $table->timestamp('visit_date')->nullable();
            $table->string('time_in')->nullable();
            $table->timestamp('time_out')->nullable();
            $table->softDeletes(); // Adds deleted_at column

        });
    }

    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
