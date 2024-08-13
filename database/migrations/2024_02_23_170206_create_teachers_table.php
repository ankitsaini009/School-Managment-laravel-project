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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(1)->comment('1=>Active,0=>Inactive');
            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('subjects');
            $table->string('classess');
            $table->string('salary');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('whatsapp_number')->nullable();
            $table->string('password');
            $table->string('profilepic')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
