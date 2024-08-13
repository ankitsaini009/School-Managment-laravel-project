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
        Schema::create('sitesettings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name',100);
            $table->string('site_email',100);
            $table->string('site_contact',13);
            $table->string('site_address');
            $table->string('site_fav_icon',100)->nullable();
            $table->string('site_logo',100)->nullable();
            $table->text('header_code')->nullable();
            $table->text('footer_code')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('insta_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkdin_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitesettings');
    }
};
