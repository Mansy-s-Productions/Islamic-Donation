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
        Schema::create('volunteer_photos', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['quran', 'hadith']);
            $table->integer('sura_id')->nullable();
            $table->integer('design_id');
            $table->integer('user_id');
            $table->string('lang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_photos');
    }
};
