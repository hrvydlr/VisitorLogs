<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorTypesTable extends Migration
{
    public function up()
    {
        Schema::create('visitor_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
            $table->string('deleted_by', 10)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitor_types');
    }
}
