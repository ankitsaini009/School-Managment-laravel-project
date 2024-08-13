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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('father_name',100);
            $table->string('mother_name',100);
            $table->integer('status')->default(1)->comment('1=>Active,0=>Inactive');
            $table->string('profilepic')->nullable();
            $table->string('signature',200)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('number',13);
            $table->integer('class');
            $table->string('subjects',100);
            $table->string('number',13);
            $table->string('number2',13)->nullable();
            $table->date('dob');
            $table->date('addmison_date');
            $table->double('fee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
