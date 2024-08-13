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
        Schema::create('addtexts', function (Blueprint $table) {
            $table->id();
            $table->integer('holder_id');
            $table->string('text');
            $table->integer('text_x_position');
            $table->integer('text_y_position');
            $table->integer('text_font_size');
            $table->string('text_font_file');
            $table->string('text_color');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addtexts');
    }
};
