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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_name');
            $table->integer('status')->default(1);
            $table->string('certificate_temp_path');
            $table->string('name_font_path');
            $table->string('discription_font_path');
            $table->text('certificate_discription');
            $table->string('discription_color',100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
